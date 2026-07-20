<?php

namespace App\Controllers;

use App\Models\OperateurModel;

class OperateurAuth extends BaseController
{
    public function login()
    {
        if ($this->request->getMethod() === 'POST') {
            $code = trim($this->request->getPost('code'));

            if (empty($code)) {
                return redirect()->back()->with('error', 'Veuillez saisir le code secret.');
            }

            $model = new OperateurModel();
            $operateur = $model->where('code_secret', $code)->first();

            if (!$operateur) {
                return redirect()->back()->with('error', 'Code secret incorrect.');
            }

            session()->set('operateur', [
                'id'  => $operateur['id'],
                'nom' => $operateur['nom'],
            ]);

            return redirect()->to('/operateur/accueil')->with('success', 'Connexion opérateur réussie.');
        }

        return view('operateur/login');
    }

public function logout()
{
    session()->remove('operateur');
    return redirect()->to('/')->with('success', 'Déconnexion réussie.');
}
}