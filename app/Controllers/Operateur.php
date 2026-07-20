<?php

namespace App\Controllers;

class Operateur extends BaseController
{
    /**
     * Page d'accueil de l'opérateur après connexion.
     */
    public function accueil()
    {
        $operateur = session()->get('operateur');
        if (!$operateur) {
            return redirect()->to('/operateur/login')->with('error', 'Veuillez vous connecter.');
        }

        return view('operateur/accueil', [
            'operateur' => $operateur,
        ]);
    }
}