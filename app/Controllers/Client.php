<?php

namespace App\Controllers;

use App\Models\RegleFraisModel;
use App\Models\ClientModel;
use App\Models\TransactionModel;

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

        $operateurId = 1; // Opérateur fixe (à adapter si plusieurs opérateurs)
        $type = 'depot';

        // Calcul des frais
        $regleFraisModel = new RegleFraisModel();
        $frais = $regleFraisModel->getFrais($operateurId, $type, $montant);

        if ($frais === null) {
            return redirect()->back()->with('error', 'Aucun barème défini pour ce montant. Contactez le support.');
        }

        // Vérifier que le solde sera suffisant ? Pour un dépôt, on crédite, donc pas de vérification.
        // Insertion de la transaction
        $transactionModel = new TransactionModel();
        $transactionData = [
            'type'          => $type,
            'montant'       => $montant,
            'frais'         => $frais,
            'emetteur_id'   => null,
            'recepteur_id'  => $client['id'],
            'operateur_id'  => $operateurId,
            'statut'        => 'termine',
        ];

        if ($transactionModel->insert($transactionData)) {
            // Mise à jour du solde en session (le trigger l'a fait en base)
            $clientModel = new ClientModel();
            $clientUpdated = $clientModel->find($client['id']);
            session()->set('client', array_merge(session()->get('client'), ['solde' => $clientUpdated['solde']]));

            return redirect()->to('/client/espace')->with('success', "Dépôt de {$montant} Ar effectué. Frais : {$frais} Ar. Votre solde a été crédité de " . ($montant - $frais) . " Ar.");
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

        $montant = (float) $this->request->getPost('montant');
        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Montant invalide.');
        }

        $operateurId = 1;
        $type = 'retrait';

        $regleFraisModel = new RegleFraisModel();
        $frais = $regleFraisModel->getFrais($operateurId, $type, $montant);
        if ($frais === null) {
            return redirect()->back()->with('error', 'Aucun barème défini pour ce montant.');
        }

        // Vérifier le solde : le client doit avoir assez pour le montant + frais
        $totalDebit = $montant + $frais;
        if ($client['solde'] < $totalDebit) {
            return redirect()->back()->with('error', "Solde insuffisant. Vous avez {$client['solde']} Ar, vous avez besoin de {$totalDebit} Ar.");
        }

        $transactionModel = new TransactionModel();
        $transactionData = [
            'type'          => $type,
            'montant'       => $montant,
            'frais'         => $frais,
            'emetteur_id'   => $client['id'],
            'recepteur_id'  => null,
            'operateur_id'  => $operateurId,
            'statut'        => 'termine',
        ];

        if ($transactionModel->insert($transactionData)) {
            $clientModel = new ClientModel();
            $clientUpdated = $clientModel->find($client['id']);
            session()->set('client', array_merge(session()->get('client'), ['solde' => $clientUpdated['solde']]));

            return redirect()->to('/client/espace')->with('success', "Retrait de {$montant} Ar effectué. Frais : {$frais} Ar. Votre solde a été débité de {$totalDebit} Ar.");
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

// Traiter le transfert
public function traitementTransfert()
{
    $client = session()->get('client');
    if (!$client) {
        return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
    }

    $montant = (float) $this->request->getPost('montant');
    $telephoneDestinataire = trim($this->request->getPost('telephone'));

    if ($montant <= 0 || empty($telephoneDestinataire)) {
        return redirect()->back()->with('error', 'Montant ou numéro invalide.');
    }

    // Ne pas se transférer à soi-même
    if ($telephoneDestinataire === $client['telephone']) {
        return redirect()->back()->with('error', 'Vous ne pouvez pas transférer vers votre propre numéro.');
    }

    $operateurId = 1;
    $type = 'transfert';

    // Calcul des frais
    $regleFraisModel = new \App\Models\RegleFraisModel();
    $frais = $regleFraisModel->getFrais($operateurId, $type, $montant);

    if ($frais === null) {
        return redirect()->back()->with('error', 'Aucun barème défini pour ce montant.');
    }

    // Vérifier solde de l'émetteur
    $totalDebit = $montant + $frais;
    if ($client['solde'] < $totalDebit) {
        return redirect()->back()->with('error', "Solde insuffisant. Vous avez {$client['solde']} Ar, le transfert coûte {$totalDebit} Ar.");
    }

    // Récupérer ou créer le destinataire
    $clientModel = new \App\Models\ClientModel();
    $destinataire = $clientModel->where('telephone', $telephoneDestinataire)->first();

    if (!$destinataire) {
        // Création automatique du destinataire s'il n'existe pas
        $destinataireId = $clientModel->insert([
            'telephone' => $telephoneDestinataire,
            'solde'     => 0.0,
        ], true);

        if (!$destinataireId) {
            return redirect()->back()->with('error', 'Erreur lors de la création du compte destinataire.');
        }
        $destinataire = $clientModel->find($destinataireId);
    }

    // Enregistrement de la transaction
    $transactionModel = new \App\Models\TransactionModel();
    $transactionData = [
        'type'          => $type,
        'montant'       => $montant,
        'frais'         => $frais,
        'emetteur_id'   => $client['id'],
        'recepteur_id'  => $destinataire['id'],
        'operateur_id'  => $operateurId,
        'statut'        => 'termine',
    ];

    if ($transactionModel->insert($transactionData)) {
        // Mise à jour du solde en session
        $clientUpdated = $clientModel->find($client['id']);
        session()->set('client', array_merge(session()->get('client'), ['solde' => $clientUpdated['solde']]));

        return redirect()->to('/client/espace')->with('success',
            "Transfert de {$montant} Ar vers {$telephoneDestinataire} effectué. Frais : {$frais} Ar. Nouveau solde : {$clientUpdated['solde']} Ar."
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

    $transactionModel = new \App\Models\TransactionModel();
    $transactions = $transactionModel->getHistoriqueClient($client['id'], $filtres);

    return view('client/historique', [
        'client'       => $client,
        'transactions' => $transactions,
        'filtres'      => $filtres,   // pour réafficher les valeurs dans le formulaire
    ]);
}


}