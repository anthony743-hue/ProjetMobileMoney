<?php

namespace App\Models;

use CodeIgniter\Model;

class OperateurModel extends Model
{
    protected $table      = 'operateurs';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['nom', 'description', 'code_secret'];

    /**
     * Vérifie le code secret d'un opérateur.
     * Retourne l'opérateur si le code est correct, null sinon.
     */
    public function verifierCode(int $id, string $code): ?array
    {
        $operateur = $this->find($id);
        if ($operateur && $operateur['code_secret'] === $code) {
            return $operateur;
        }
        return null;
    }

        /**
     * Récupère un opérateur par son ID.
     */
    public function getOperateur(int $id): ?array
    {
        return $this->find($id);
    }
}