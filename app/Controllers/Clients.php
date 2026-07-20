<?php

namespace App\Controllers;

use App\Models\ClientModel;

class Clients extends BaseController
{
    /**
     * Retourne l'ID de l'opérateur connecté (si nécessaire pour des filtres futurs).
     */
    private function getOperateurId(): int
    {
        return session()->get('operateur')['id'];
    }

    public function situation()
    {
        // Vérification supplémentaire (le filtre l'assure déjà)
        if (!session()->get('operateur')) {
            return redirect()->to('/operateur/login')->with('error', 'Veuillez vous connecter.');
        }

        $clientModel = new ClientModel();
        $clients = $clientModel->getAllClients();
        $totaux  = $clientModel->getTotaux();

        return view('clients/situation', [
            'clients' => $clients,
            'totaux'  => $totaux,
        ]);
    }
}