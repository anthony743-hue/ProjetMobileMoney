<?php

namespace App\Controllers;

use App\Models\OperateurModel;

class Operateurs extends BaseController
{
    public function profil()
    {
        // Vérifier que l'opérateur est bien connecté
        $operateurSession = session()->get('operateur');
        if (!$operateurSession) {
            return redirect()->to('/operateur/login')->with('error', 'Veuillez vous connecter.');
        }

        $model = new OperateurModel();
        $id = $operateurSession['id'];

        // Récupération des données actuelles de l'opérateur
        $operateurData = $model->find($id);
        if (!$operateurData) {
            // Cas improbable : l'opérateur a été supprimé de la base
            session()->remove('operateur');
            return redirect()->to('/operateur/login')->with('error', 'Session invalide, veuillez vous reconnecter.');
        }

        if ($this->request->getMethod() === 'POST') {
            $commission = $this->request->getPost('commission_inter_operateur');

            // Validation : valeur numérique
            if ($commission === null || !is_numeric($commission)) {
                return redirect()->back()->with('error', 'Veuillez entrer une valeur numérique valide.')->withInput();
            }

            $commission = (float) $commission;

            // Mise à jour directe via le Query Builder (contourne les restrictions du modèle)
            $db = \Config\Database::connect();
            $builder = $db->table('operateurs');
            $builder->where('id', $id);
            $builder->update(['commission_inter_operateur' => $commission]);

            // Vérifier si une ligne a été affectée (optionnel)
            if ($db->affectedRows() > 0) {
                return redirect()->to('/operateur/accueil')->with('success', 'Commission mise à jour avec succès.');
            } else {
                // Aucune ligne modifiée → la valeur était déjà identique
                return redirect()->to('/operateur/accueil')->with('info', 'Aucune modification effectuée (valeur inchangée).');
            }
        }

        return view('operateurs/profil', [
            'operateurData' => $operateurData,
        ]);
    }
}