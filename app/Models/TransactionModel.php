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
}