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
        'commission_externe',
        'emetteur_id',
        'recepteur_id',
        'operateur_id',
        'statut',
        'groupe_id'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = false;

    /**
     * Récupère les statistiques de gains pour un opérateur donné.
     */
    public function getGainsSummary(int $operateurId): array
    {
        $query = $this->db->query(
            "SELECT type,
                    COUNT(*) as nb_operations,
                    SUM(montant) as montant_total,
                    SUM(frais) as frais_total,
                    SUM(commission_externe) as commission_totale
             FROM transactions
             WHERE operateur_id = ? AND statut = 'termine'
             GROUP BY type",
            [$operateurId]
        );

        $resultats = [];
        foreach ($query->getResultArray() as $row) {
            $resultats[$row['type']] = [
                'nb_operations'     => (int) $row['nb_operations'],
                'montant_total'     => (float) $row['montant_total'],
                'frais_total'       => (float) $row['frais_total'],
                'commission_totale' => (float) $row['commission_totale'],
            ];
        }

        // S'assurer que les trois types existent
        foreach (['depot', 'retrait', 'transfert'] as $type) {
            if (!isset($resultats[$type])) {
                $resultats[$type] = [
                    'nb_operations'     => 0,
                    'montant_total'     => 0.0,
                    'frais_total'       => 0.0,
                    'commission_totale' => 0.0,
                ];
            }
        }

        return $resultats;
    }

    /**
     * Historique d'un client.
     */
    public function getHistoriqueClient(int $clientId, array $filtres = [], int $limit = 50): array
    {
        $builder = $this->select('transactions.*, 
                                  e.telephone AS emetteur_telephone, 
                                  r.telephone AS recepteur_telephone')
                        ->join('clients e', 'e.id = transactions.emetteur_id', 'left')
                        ->join('clients r', 'r.id = transactions.recepteur_id', 'left')
                        ->groupStart()
                            ->where('emetteur_id', $clientId)
                            ->orWhere('recepteur_id', $clientId)
                        ->groupEnd();

        if (!empty($filtres['type'])) {
            $builder->where('transactions.type', $filtres['type']);
        }
        if (!empty($filtres['date_debut'])) {
            $builder->where('date_transaction >=', $filtres['date_debut'] . ' 00:00:00');
        }
        if (!empty($filtres['date_fin'])) {
            $builder->where('date_transaction <=', $filtres['date_fin'] . ' 23:59:59');
        }

        return $builder->orderBy('date_transaction', 'DESC')
                       ->limit($limit)
                       ->find();
    }



/**
 * Calcule les montants à reverser aux opérateurs concurrents
 * suite aux transferts émis par notre opérateur.
 */
public function getReversementsParOperateur(int $operateurId): array
{
    $query = $this->db->query(
        "SELECT o.id, o.nom, SUM(t.montant) AS total_montant
         FROM transactions t
         JOIN clients c ON t.recepteur_id = c.id
         JOIN prefixes_operateur p ON c.telephone LIKE p.prefixe || '%'
         JOIN operateurs o ON p.operateur_id = o.id
         WHERE t.type = 'transfert'
           AND t.operateur_id = ?
           AND o.id != ?
           AND t.statut = 'termine'
         GROUP BY o.id
         ORDER BY total_montant DESC",
        [$operateurId, $operateurId]
    );
    return $query->getResultArray();
}

// Optionnel : récupérer les transactions groupées par groupe_id
public function getGroupe(string $groupeId): array
{
    return $this->where('groupe_id', $groupeId)->findAll();
}

}