<?php

namespace App\Controllers;

class Client extends BaseController
{
    // Affiche l'espace client (solde, menu)
    public function espace()
    {
        $client = session()->get('client');
        if (!$client) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        return view('client/espace', ['client' => $client]);
    }
}