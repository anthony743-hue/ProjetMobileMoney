<?php

namespace App\Controllers;

use App\Models\RegleFraisModel;
use App\Models\ClientModel;
use App\Models\TransactionModel;
use App\Models\PrefixeOperateurModel;
use App\Models\OperateurModel;

class Client extends BaseController
{
    public function espace()
    {
        $client = session()->get('client');
        if (!$client) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        // Recharger le client depuis la base pour avoir le solde à jour
        $clientModel = new ClientModel();
        $client = $clientModel->find($client['id']);
        session()->set('client', [
            'id'        => $client['id'],
            'telephone' => $client['telephone'],
            'prenom'    => $client['prenom'] ?? '',
            'nom'       => $client['nom'] ?? '',
            'solde'     => $client['solde'],
        ]);

        return view('client/espace', ['client' => $client]);
    }

    // Afficher le formulaire de dépôt
    public function depot()
    {
        $client = session()->get('client');
        if (!$client) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        return view('client/depot', ['client' => $client]);
    }

    // Traiter le dépôt
    public function traitementDepot()
    {
        $client = session()->get('client');
        if (!$client) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $montant = (float) $this->request->getPost('montant');
        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Montant invalide.');
        }

        $operateurId = 1;
        $type = 'depot';

        // Calcul des frais selon le barème
        $regleFraisModel = new RegleFraisModel();
        $frais = $regleFraisModel->getFrais($operateurId, $type, $montant);

        // Si aucun barème trouvé, on applique 0 frais (dépôt gratuit par défaut)
        if ($frais === null) {
            $frais = 0.0;
        }

        // Insertion de la transaction
        $transactionModel = new TransactionModel();
        $transactionData = [
            'type'              => $type,
            'montant'           => $montant,
            'frais'             => $frais,
            'commission_externe'=> 0.0,
            'emetteur_id'       => null,
            'recepteur_id'      => $client['id'],
            'operateur_id'      => $operateurId,
            'statut'            => 'termine',
        ];

        if ($transactionModel->insert($transactionData)) {
            $clientModel = new ClientModel();
            $clientUpdated = $clientModel->find($client['id']);
            session()->set('client', array_merge(session()->get('client'), ['solde' => $clientUpdated['solde']]));

            $message = "Dépôt de {$montant} Ar effectué.";
            if ($frais > 0) {
                $message .= " Frais : {$frais} Ar. Votre solde a été crédité de " . ($montant - $frais) . " Ar.";
            } else {
                $message .= " Aucun frais appliqué. Votre solde a été crédité de {$montant} Ar.";
            }
            return redirect()->to('/client/espace')->with('success', $message);
        } else {
            return redirect()->back()->with('error', 'Erreur lors de l\'enregistrement de la transaction.');
        }
    }

    // Afficher le formulaire de retrait
    public function retrait()
    {
        $client = session()->get('client');
        if (!$client) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        return view('client/retrait', ['client' => $client]);
    }

    // Traiter le retrait
public function traitementRetrait()
{
    $client = session()->get('client');
    if (!$client) {
        return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
    }

    $montantSaisi = (float) $this->request->getPost('montant');
    $fraisInclus = (bool) $this->request->getPost('frais_inclus');

    if ($montantSaisi <= 0) {
        return redirect()->back()->with('error', 'Montant invalide.');
    }

    $operateurId = 1;
    $type = 'retrait';
    $regleFraisModel = new RegleFraisModel();

    if ($fraisInclus) {
        // Le client veut que le montant saisi soit le total débiteur (montant retiré + frais)
        // On doit déterminer le montant réellement retiré (M) et les frais (F) tels que M + F = montantSaisi
        // On parcourt les barèmes pour trouver une combinaison cohérente.
        $barèmes = $regleFraisModel->getRegles($operateurId, $type);
        $trouve = false;
        foreach ($barèmes as $barème) {
            $frais = (float) $barème['frais'];
            $M = $montantSaisi - $frais;
            if ($M >= $barème['montant_min'] && $M <= $barème['montant_max']) {
                $trouve = true;
                break;
            }
        }
        if (!$trouve) {
            // Aucun barème ne correspond, on prend le barème le plus proche ? Par défaut, on refuse.
            return redirect()->back()->with('error', 'Impossible de déterminer les frais pour ce montant total. Veuillez décocher l\'option ou saisir un autre montant.');
        }
        $montantRetire = $M;
        $totalDebit = $montantSaisi;
    } else {
        // Frais en plus
        $frais = $regleFraisModel->getFrais($operateurId, $type, $montantSaisi);
        if ($frais === null) {
            $frais = 0.0;
        }
        $montantRetire = $montantSaisi;
        $totalDebit = $montantSaisi + $frais;
    }

    if ($client['solde'] < $totalDebit) {
        return redirect()->back()->with('error', "Solde insuffisant. Vous avez {$client['solde']} Ar, vous avez besoin de {$totalDebit} Ar.");
    }

    $transactionModel = new TransactionModel();
    $transactionData = [
        'type'              => $type,
        'montant'           => $montantRetire,   // montant effectivement retiré
        'frais'             => $frais,
        'commission_externe'=> 0.0,
        'emetteur_id'       => $client['id'],
        'recepteur_id'      => null,
        'operateur_id'      => $operateurId,
        'statut'            => 'termine',
    ];

    if ($transactionModel->insert($transactionData)) {
        $clientModel = new ClientModel();
        $clientUpdated = $clientModel->find($client['id']);
        session()->set('client', array_merge(session()->get('client'), ['solde' => $clientUpdated['solde']]));
        $message = "Retrait de {$montantRetire} Ar effectué. Frais : {$frais} Ar. Votre solde a été débité de {$totalDebit} Ar.";
        return redirect()->to('/client/espace')->with('success', $message);
    } else {
        return redirect()->back()->with('error', 'Erreur lors de l\'enregistrement de la transaction.');
    }
}

    // Afficher le formulaire de transfert
    public function transfert()
    {
        $client = session()->get('client');
        if (!$client) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        return view('client/transfert', ['client' => $client]);
    }

    // Traiter le transfert (version finale avec commission externe séparée)
 public function traitementTransfert()
{
    $client = session()->get('client');
    if (!$client) {
        return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
    }

    $montantSaisi = (float) $this->request->getPost('montant');
    $telephoneDestinataire = trim($this->request->getPost('telephone'));
    $fraisInclus = (bool) $this->request->getPost('frais_inclus');

    if ($montantSaisi <= 0 || empty($telephoneDestinataire)) {
        return redirect()->back()->with('error', 'Montant ou numéro invalide.');
    }
    if ($telephoneDestinataire === $client['telephone']) {
        return redirect()->back()->with('error', 'Vous ne pouvez pas transférer vers votre propre numéro.');
    }

    $operateurId = 1;
    $type = 'transfert';
    $regleFraisModel = new RegleFraisModel();
    $prefixModel = new PrefixeOperateurModel();
    $operateurModel = new OperateurModel();
    $operateurEmetteur = $operateurModel->find($operateurId);
    $tauxCommission = (float) ($operateurEmetteur['commission_inter_operateur'] ?? 0);

    // Déterminer si le destinataire est externe
    $operateurDest = $prefixModel->getOperateurByTelephone($telephoneDestinataire);
    $estExterne = ($operateurDest && $operateurDest['id'] != $operateurId);

    if ($fraisInclus) {
        // Le montant saisi est le total débité (M + frais fixes + éventuelle commission)
        // On doit trouver M (montant transféré) et les frais correspondants
        $barèmes = $regleFraisModel->getRegles($operateurId, $type);
        $trouve = false;
        foreach ($barèmes as $barème) {
            $fraisFixes = (float) $barème['frais'];
            if ($estExterne && $tauxCommission > 0) {
                // M + fraisFixes + taux*M = total => M = (total - fraisFixes) / (1 + taux)
                $M = ($montantSaisi - $fraisFixes) / (1 + $tauxCommission / 100.0);
            } else {
                $M = $montantSaisi - $fraisFixes;
            }
            if ($M >= $barème['montant_min'] && $M <= $barème['montant_max']) {
                $trouve = true;
                break;
            }
        }
        if (!$trouve) {
            return redirect()->back()->with('error', 'Impossible de déterminer les frais pour ce montant total. Veuillez décocher l\'option ou saisir un autre montant.');
        }
        $montantTransfert = round($M, 2);
        $fraisFixes = $fraisFixes;
        $commission = $estExterne ? round($montantTransfert * $tauxCommission / 100.0, 2) : 0.0;
        $fraisTotal = $fraisFixes + $commission;
        $totalDebit = $montantSaisi; // déjà égal à M + fraisTotal
    } else {
        // Frais en plus
        $fraisFixes = $regleFraisModel->getFrais($operateurId, $type, $montantSaisi);
        if ($fraisFixes === null) {
            $fraisFixes = 0.0;
        }
        $commission = 0.0;
        if ($estExterne && $tauxCommission > 0) {
            $commission = $montantSaisi * ($tauxCommission / 100.0);
        }
        $fraisTotal = $fraisFixes + $commission;
        $montantTransfert = $montantSaisi;
        $totalDebit = $montantSaisi + $fraisTotal;
    }

    if ($client['solde'] < $totalDebit) {
        return redirect()->back()->with('error', "Solde insuffisant. Vous avez {$client['solde']} Ar, le transfert coûte {$totalDebit} Ar.");
    }

    // Récupération ou création du destinataire
    $clientModel = new ClientModel();
    $destinataire = $clientModel->where('telephone', $telephoneDestinataire)->first();
    if (!$destinataire) {
        $destinataireId = $clientModel->insert(['telephone' => $telephoneDestinataire, 'solde' => 0.0], true);
        if (!$destinataireId) {
            return redirect()->back()->with('error', 'Erreur lors de la création du compte destinataire.');
        }
        $destinataire = $clientModel->find($destinataireId);
    }

    $transactionModel = new TransactionModel();
    $transactionData = [
        'type'              => $type,
        'montant'           => $montantTransfert,
        'frais'             => $fraisTotal,
        'commission_externe'=> $commission,
        'emetteur_id'       => $client['id'],
        'recepteur_id'      => $destinataire['id'],
        'operateur_id'      => $operateurId,
        'statut'            => 'termine',
    ];

    if ($transactionModel->insert($transactionData)) {
        $clientUpdated = $clientModel->find($client['id']);
        session()->set('client', array_merge(session()->get('client'), ['solde' => $clientUpdated['solde']]));
        return redirect()->to('/client/espace')->with('success',
            "Transfert de {$montantTransfert} Ar vers {$telephoneDestinataire} effectué. Frais : {$fraisTotal} Ar. Nouveau solde : {$clientUpdated['solde']} Ar."
        );
    } else {
        return redirect()->back()->with('error', 'Erreur lors de l\'enregistrement du transfert.');
    }
}
    public function historique()
    {
        $client = session()->get('client');
        if (!$client) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        // Récupération des filtres depuis l'URL
        $filtres = [
            'type'       => $this->request->getGet('type'),
            'date_debut' => $this->request->getGet('date_debut'),
            'date_fin'   => $this->request->getGet('date_fin'),
        ];

        $transactionModel = new TransactionModel();
        $transactions = $transactionModel->getHistoriqueClient($client['id'], $filtres);

        return view('client/historique', [
            'client'       => $client,
            'transactions' => $transactions,
            'filtres'      => $filtres,
        ]);
    }





// Afficher le formulaire d'envoi multiple
public function transfertMultiple()
{
    $client = session()->get('client');
    if (!$client) {
        return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
    }
    return view('client/transfert_multiple', ['client' => $client]);
}

// Traiter l'envoi multiple
public function traitementTransfertMultiple()
{
    $client = session()->get('client');
    if (!$client) {
        return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
    }

    $montantTotal = (float) $this->request->getPost('montant_total');
    $numeros = $this->request->getPost('numeros'); // tableau de numéros

    if ($montantTotal <= 0 || empty($numeros) || !is_array($numeros)) {
        return redirect()->back()->with('error', 'Montant invalide ou aucun destinataire.');
    }

    // Nettoyer les numéros (enlever les vides et les doublons)
    $numeros = array_unique(array_filter(array_map('trim', $numeros)));
    $nbDestinataires = count($numeros);

    if ($nbDestinataires === 0) {
        return redirect()->back()->with('error', 'Aucun numéro valide.');
    }

    // Interdire l'envoi à soi-même
    if (in_array($client['telephone'], $numeros)) {
        return redirect()->back()->with('error', 'Vous ne pouvez pas vous inclure dans les destinataires.');
    }

    // Montant par destinataire (arrondi à l'entier inférieur, le reste est ignoré)
    $montantParDestinataire = floor($montantTotal / $nbDestinataires);
    if ($montantParDestinataire <= 0) {
        return redirect()->back()->with('error', 'Le montant par destinataire est trop faible.');
    }

    $operateurId = 1; // Votre opérateur
    $regleFraisModel = new \App\Models\RegleFraisModel();
    $prefixModel = new \App\Models\PrefixeOperateurModel();
    $operateurModel = new \App\Models\OperateurModel();
    $operateurEmetteur = $operateurModel->find($operateurId);
    $tauxCommission = (float)($operateurEmetteur['commission_inter_operateur'] ?? 0);

    $totalDebitGlobal = 0;
    $transactions = []; // pour stocker les données avant insertion

    foreach ($numeros as $destinataireTel) {
        // Déterminer si le destinataire est externe
        $operateurDest = $prefixModel->getOperateurByTelephone($destinataireTel);
        $estExterne = ($operateurDest && $operateurDest['id'] != $operateurId);

        // Frais fixes
        $fraisFixes = $regleFraisModel->getFrais($operateurId, 'transfert', $montantParDestinataire);
        if ($fraisFixes === null) {
            $fraisFixes = 0.0;
        }

        // Commission éventuelle
        $commission = 0.0;
        if ($estExterne && $tauxCommission > 0) {
            $commission = $montantParDestinataire * ($tauxCommission / 100.0);
        }

        $fraisTotal = $fraisFixes + $commission;
        $debitLigne = $montantParDestinataire + $fraisTotal;
        $totalDebitGlobal += $debitLigne;

        // Vérifier si le destinataire existe, sinon le créer
        $clientModel = new \App\Models\ClientModel();
        $destinataire = $clientModel->where('telephone', $destinataireTel)->first();
        if (!$destinataire) {
            $destinataireId = $clientModel->insert(['telephone' => $destinataireTel, 'solde' => 0.0], true);
            if (!$destinataireId) {
                return redirect()->back()->with('error', "Erreur lors de la création du compte $destinataireTel.");
            }
            $destinataire = $clientModel->find($destinataireId);
        }

        $transactions[] = [
            'type'              => 'transfert',
            'montant'           => $montantParDestinataire,
            'frais'             => $fraisTotal,
            'commission_externe'=> $commission,
            'emetteur_id'       => $client['id'],
            'recepteur_id'      => $destinataire['id'],
            'operateur_id'      => $operateurId,
            'statut'            => 'termine',
        ];
    }

    // Vérifier le solde global
    if ($client['solde'] < $totalDebitGlobal) {
        return redirect()->back()->with('error', "Solde insuffisant. Vous avez {$client['solde']} Ar, vous avez besoin de {$totalDebitGlobal} Ar.");
    }

    // Générer un identifiant de groupe unique
    $groupeId = uniqid('G-', true);

    // Insérer toutes les transactions dans une transaction SQL (si possible) ou une boucle
    $transactionModel = new \App\Models\TransactionModel();
    $db = \Config\Database::connect();
    $db->transStart(); // Début de transaction

    foreach ($transactions as &$t) {
        $t['groupe_id'] = $groupeId;
        $transactionModel->insert($t);
    }

    $db->transComplete(); // Valide tout ou rollback

    if ($db->transStatus() === false) {
        return redirect()->back()->with('error', 'Erreur lors de l\'enregistrement des transferts.');
    }

    // Mettre à jour le solde en session
    $clientModel = new \App\Models\ClientModel();
    $clientUpdated = $clientModel->find($client['id']);
    session()->set('client', array_merge(session()->get('client'), ['solde' => $clientUpdated['solde']]));

    return redirect()->to('/client/espace')->with('success',
        "Envoi multiple effectué : {$nbDestinataires} transferts de {$montantParDestinataire} Ar chacun. Total débité : {$totalDebitGlobal} Ar."
    );
}





}