<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table      = 'transactions';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false;

    /**
     * Récupère les statistiques de gains pour un opérateur donné.
     * Retourne un tableau associatif avec les totaux par type de transaction.
     */
    public function getGainsSummary(int $operateurId): array
    {
        // Requête brute pour obtenir les agrégats par type
        $query = $this->db->query(
            "SELECT type,
                    COUNT(*) as nb_operations,
                    SUM(montant) as montant_total,
                    SUM(frais) as frais_total
             FROM transactions
             WHERE operateur_id = ? AND statut = 'termine'
             GROUP BY type",
            [$operateurId]
        );

        $resultats = [];
        foreach ($query->getResultArray() as $row) {
            $resultats[$row['type']] = [
                'nb_operations' => (int) $row['nb_operations'],
                'montant_total' => (float) $row['montant_total'],
                'frais_total'   => (float) $row['frais_total'],
            ];
        }

        // On s’assure que les trois types existent, même vides
        foreach (['depot', 'retrait', 'transfert'] as $type) {
            if (!isset($resultats[$type])) {
                $resultats[$type] = [
                    'nb_operations' => 0,
                    'montant_total' => 0.0,
                    'frais_total'   => 0.0,
                ];
            }
        }

        return $resultats;
    }
}