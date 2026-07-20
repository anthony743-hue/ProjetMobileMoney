<?php

namespace App\Controllers;

use App\Models\PrefixeOperateurModel;
use App\Models\OperateurModel;

class Prefixes extends BaseController
{
    /**
     * Liste de tous les préfixes.
     */
    public function index()
    {
        $model = new PrefixeOperateurModel();
        $prefixes = $model->getPrefixesWithOperateur();

        return view('prefixes/liste', [
            'prefixes' => $prefixes,
        ]);
    }

    /**
     * Formulaire d'ajout.
     */
    public function ajouter()
    {
        $operateurModel = new OperateurModel();
        $operateurs = $operateurModel->findAll();

        if ($this->request->getMethod() === 'POST') {
            $data = [
                'operateur_id' => $this->request->getPost('operateur_id'),
                'prefixe'      => trim($this->request->getPost('prefixe')),
            ];

            // Vérification : le préfixe ne doit pas déjà exister
            $prefixModel = new PrefixeOperateurModel();
            $existant = $prefixModel->where('prefixe', $data['prefixe'])->first();
            if ($existant) {
                return redirect()->back()->with('error', 'Ce préfixe existe déjà.')->withInput();
            }

            if ($prefixModel->insert($data)) {
                return redirect()->to('/prefixes')->with('success', 'Préfixe ajouté avec succès.');
            } else {
                return redirect()->back()->with('error', 'Erreur lors de l\'ajout.')->withInput();
            }
        }

        return view('prefixes/form', [
            'operateurs' => $operateurs,
            'prefixe'    => null,
        ]);
    }

    /**
     * Formulaire de modification.
     */
    public function modifier($id)
    {
        $prefixModel = new PrefixeOperateurModel();
        $prefixe = $prefixModel->find($id);

        if (!$prefixe) {
            return redirect()->to('/prefixes')->with('error', 'Préfixe introuvable.');
        }

        $operateurModel = new OperateurModel();
        $operateurs = $operateurModel->findAll();

        if ($this->request->getMethod() === 'POST') {
            $data = [
                'operateur_id' => $this->request->getPost('operateur_id'),
                'prefixe'      => trim($this->request->getPost('prefixe')),
            ];

            // Vérifier l'unicité (en excluant l'ID actuel)
            $existant = $prefixModel->where('prefixe', $data['prefixe'])
                                    ->where('id !=', $id)
                                    ->first();
            if ($existant) {
                return redirect()->back()->with('error', 'Ce préfixe existe déjà.')->withInput();
            }

            if ($prefixModel->update($id, $data)) {
                return redirect()->to('/prefixes')->with('success', 'Préfixe modifié.');
            } else {
                return redirect()->back()->with('error', 'Erreur lors de la modification.')->withInput();
            }
        }

        return view('prefixes/form', [
            'operateurs' => $operateurs,
            'prefixe'    => $prefixe,
        ]);
    }

    /**
     * Suppression d'un préfixe.
     */
    public function supprimer($id)
    {
        $prefixModel = new PrefixeOperateurModel();
        $prefixe = $prefixModel->find($id);

        if (!$prefixe) {
            return redirect()->to('/prefixes')->with('error', 'Préfixe introuvable.');
        }

        $prefixModel->delete($id);
        return redirect()->to('/prefixes')->with('success', 'Préfixe supprimé.');
    }
}