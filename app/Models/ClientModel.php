<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table      = 'clients';
    protected $primaryKey = 'id';

    // Ajout des champs autorisés en insertion/modification
    protected $allowedFields = [
        'telephone',
        'prenom',
        'nom',
        'solde',
        'date_creation',
    ];

    protected $returnType = 'array';
    protected $useTimestamps = false;

    /**
     * Récupère tous les clients avec leurs soldes.
     */
    public function getAllClients(): array
    {
        return $this->orderBy('telephone', 'ASC')->findAll();
    }

    /**
     * Retourne le nombre total de clients et la somme des soldes.
     */
    public function getTotaux(): array
    {
        $query = $this->selectCount('id', 'total_clients')
                      ->selectSum('solde', 'total_soldes')
                      ->first();

        return [
            'total_clients' => (int) ($query['total_clients'] ?? 0),
            'total_soldes'  => (float) ($query['total_soldes'] ?? 0.0),
        ];
    }
}