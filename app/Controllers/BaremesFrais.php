<?php

namespace App\Controllers;

use App\Models\RegleFraisModel;
use App\Models\TransactionModel;

class BaremesFrais extends BaseController
{
    /**
     * Retourne l'ID de l'opérateur connecté.
     * (la session est garantie par le filtre)
     */
    private function getOperateurId(): int
    {
        return session()->get('operateur')['id'];
    }

    // Liste des barèmes
    public function index()
    {
        $operateurId = $this->getOperateurId();
        $typeTransaction = $this->request->getVar('type') ?? 'depot';

        $model = new RegleFraisModel();
        $regles = $model->getRegles($operateurId, $typeTransaction);

        return view('baremes/liste', [
            'regles'          => $regles,
            'operateurId'     => $operateurId,
            'typeTransaction' => $typeTransaction,
        ]);
    }

    // Ajouter un barème
    public function ajouter()
    {
        $model = new RegleFraisModel();

        if ($this->request->getMethod() === 'POST') {
            $data = [
                'operateur_id'     => $this->request->getPost('operateur_id'),
                'type_transaction' => $this->request->getPost('type_transaction'),
                'montant_min'      => (float) $this->request->getPost('montant_min'),
                'montant_max'      => (float) $this->request->getPost('montant_max'),
                'frais'             => (float) $this->request->getPost('frais'),
                'est_pourcentage'  => 0,
            ];

            if ($data['montant_min'] > $data['montant_max']) {
                return redirect()->back()->with('error', 'Le montant minimum ne peut pas dépasser le montant maximum.');
            }

            if ($model->chevauchement(
                $data['operateur_id'],
                $data['type_transaction'],
                $data['montant_min'],
                $data['montant_max']
            )) {
                return redirect()->back()->with('error', 'La tranche chevauche une règle existante.');
            }

            if (!$model->insert($data)) {
                return redirect()->back()->with('error', 'Erreur lors de l’ajout du barème.');
            }

            return redirect()->to('/baremes?type=' . $data['type_transaction'])->with('success', 'Barème ajouté avec succès.');
        }

        return view('baremes/form', [
            'regle'       => null,
            'operateurId' => $this->getOperateurId(),
            'type'        => $this->request->getGet('type') ?? 'depot',
        ]);
    }

    // Modifier un barème
    public function modifier($id)
    {
        $model = new RegleFraisModel();
        $regle = $model->find($id);

        if (!$regle) {
            return redirect()->to('/baremes')->with('error', 'Barème introuvable.');
        }

        if ($this->request->getMethod() === 'POST') {
            $data = [
                'operateur_id'     => $this->request->getPost('operateur_id'),
                'type_transaction' => $this->request->getPost('type_transaction'),
                'montant_min'      => (float) $this->request->getPost('montant_min'),
                'montant_max'      => (float) $this->request->getPost('montant_max'),
                'frais'             => (float) $this->request->getPost('frais'),
            ];

            if ($data['montant_min'] > $data['montant_max']) {
                return redirect()->back()->with('error', 'Le montant minimum ne peut pas dépasser le montant maximum.');
            }

            if ($model->chevauchement(
                $data['operateur_id'],
                $data['type_transaction'],
                $data['montant_min'],
                $data['montant_max'],
                $id
            )) {
                return redirect()->back()->with('error', 'La tranche chevauche une règle existante.');
            }

            if (!$model->update($id, $data)) {
                return redirect()->back()->with('error', 'Erreur lors de la modification.');
            }

            return redirect()->to('/baremes?type=' . $data['type_transaction'])->with('success', 'Barème modifié avec succès.');
        }

        return view('baremes/form', [
            'regle'       => $regle,
            'operateurId' => $regle['operateur_id'],
            'type'        => $regle['type_transaction'],
        ]);
    }

    // Supprimer un barème
    public function supprimer($id)
    {
        $model = new RegleFraisModel();
        $regle = $model->find($id);

        if (!$regle) {
            return redirect()->to('/baremes')->with('error', 'Barème introuvable.');
        }

        $type = $regle['type_transaction'];

        if (!$model->delete($id)) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression.');
        }

        return redirect()->to('/baremes?type=' . $type)->with('success', 'Barème supprimé avec succès.');
    }

    // Situation des gains
    public function situation()
    {
        $operateurId = $this->getOperateurId();

        $transactionModel = new TransactionModel();
        $gainsParType = $transactionModel->getGainsSummary($operateurId);

        $totalGains = 0;
        foreach ($gainsParType as $stats) {
            $totalGains += $stats['frais_total'];
        }

        return view('baremes/situation', [
            'gainsParType' => $gainsParType,
            'totalGains'   => $totalGains,
            'operateurId'  => $operateurId,
        ]);
    }


    public function reversements()
{
    $operateurId = $this->getOperateurId();

    $transactionModel = new \App\Models\TransactionModel();
    $reversements = $transactionModel->getReversementsParOperateur($operateurId);

    return view('baremes/reversements', [
        'reversements' => $reversements,
    ]);
}
}