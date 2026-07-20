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