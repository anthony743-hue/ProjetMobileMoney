<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixeOperateurModel extends Model
{
    protected $table      = 'prefixes_operateur';
    protected $primaryKey = 'id';
    protected $allowedFields = ['operateur_id', 'prefixe'];
    protected $returnType = 'array';
    protected $useTimestamps = false;

    public function getPrefixesWithOperateur(): array
    {
        return $this->select('prefixes_operateur.*, operateurs.nom AS operateur_nom')
                    ->join('operateurs', 'operateurs.id = prefixes_operateur.operateur_id')
                    ->orderBy('prefixe', 'ASC')
                    ->findAll();
    }

    public function getOperateurByTelephone(string $telephone): ?array
    {
        $prefixes = $this->orderBy('LENGTH(prefixe)', 'DESC')->findAll();
        foreach ($prefixes as $p) {
            if (strpos($telephone, $p['prefixe']) === 0) {
                return $this->db->table('operateurs')
                                ->where('id', $p['operateur_id'])
                                ->get()
                                ->getRowArray();
            }
        }
        return null;
    }
}