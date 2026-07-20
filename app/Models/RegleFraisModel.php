<?php

namespace App\Models;

use CodeIgniter\Model;

class RegleFraisModel extends Model
{
    protected $table      = 'regles_frais';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'operateur_id',
        'type_transaction',
        'montant_min',
        'montant_max',
        'frais',
        'est_pourcentage'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = false;

    // Récupérer les barèmes pour un opérateur, filtrés par type de transaction
    public function getRegles(int $operateurId, string $typeTransaction = 'depot')
    {
        return $this->where('operateur_id', $operateurId)
                    ->where('type_transaction', $typeTransaction)
                    ->orderBy('montant_min', 'ASC')
                    ->findAll();
    }

    // Vérifier le chevauchement de tranches avant insertion/modification
    public function chevauchement(int $operateurId, string $type, float $min, float $max, ?int $excludeId = null)
    {
        $builder = $this->builder();
        $builder->where('operateur_id', $operateurId)
                ->where('type_transaction', $type)
                ->groupStart()
                    ->where('montant_min <=', $max)
                    ->where('montant_max >=', $min)
                ->groupEnd();

        if ($excludeId !== null) {
            $builder->where('id !=', $excludeId);
        }

        return $builder->countAllResults() > 0;
    }
}