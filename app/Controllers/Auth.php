<?php

namespace App\Controllers;

use App\Models\ClientModel;

class Auth extends BaseController
{
    public function login()
    {
        if ($this->request->getMethod() === 'POST') {
            $telephone = trim($this->request->getPost('telephone'));

            // Validation simple : numéro non vide
            if (empty($telephone)) {
                return redirect()->back()->with('error', 'Veuillez saisir un numéro de téléphone.');
            }

            $clientModel = new ClientModel();

            // Recherche du client par téléphone
            $client = $clientModel->where('telephone', $telephone)->first();

            if (!$client) {
                // Création automatique du client s'il n'existe pas
                $clientId = $clientModel->insert([
                    'telephone' => $telephone,
                    'solde'     => 0.0,
                    // prénom et nom peuvent rester vides
                ], true);

                if (!$clientId) {
                    return redirect()->back()->with('error', 'Erreur lors de la création du compte.');
                }

                $client = $clientModel->find($clientId);
            }

            // Stockage en session
            session()->set('client', [
                'id'        => $client['id'],
                'telephone' => $client['telephone'],
                'prenom'    => $client['prenom'] ?? '',
                'nom'       => $client['nom'] ?? '',
                'solde'     => $client['solde'],
            ]);

            return redirect()->to('/client/espace')->with('success', 'Connexion réussie.');
        }

        return view('auth/login');
    }

    public function logout()
    {
        session()->remove('client');
        return redirect()->to('/login')->with('success', 'Déconnexion réussie.');
    }
}