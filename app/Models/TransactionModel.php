<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table      = 'transactions';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'type',
        'montant',
        'frais',
        'emetteur_id',
        'recepteur_id',
        'operateur_id',
        'statut',
    ];

    protected $returnType = 'array';
    protected $useTimestamps = false;

    /**
     * Récupère les statistiques de gains pour un opérateur donné.
     * Retourne un tableau associatif avec les totaux par type de transaction.
     */
    public function getGainsSummary(int $operateurId): array
    {
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

        // S'assurer que les trois types existent, même vides
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

    /**
     * Récupère l'historique des transactions d'un client (émetteur ou récepteur).
     */
    public function getHistoriqueClient(int $clientId, int $limit = 50): array
    {
        return $this->select('transactions.*, 
                              e.telephone AS emetteur_telephone, 
                              r.telephone AS recepteur_telephone')
                    ->join('clients e', 'e.id = transactions.emetteur_id', 'left')
                    ->join('clients r', 'r.id = transactions.recepteur_id', 'left')
                    ->groupStart()
                        ->where('emetteur_id', $clientId)
                        ->orWhere('recepteur_id', $clientId)
                    ->groupEnd()
                    ->orderBy('date_transaction', 'DESC')
                    ->limit($limit)
                    ->find();
    }
}