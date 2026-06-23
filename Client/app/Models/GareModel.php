<?php

namespace App\Models;

use CodeIgniter\Model;

class GareModel extends Model
{
    protected $table = 'gares';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'nom',
        'ville',
        'position'
    ];

    protected $useTimestamps = false;

    /**
     * Récupérer toutes les gares
     */
    public function getAllGares()
    {
        return $this->orderBy('ville', 'ASC')->findAll();
    }

    /**
     * Récupérer les gares par ville
     */
    public function getGaresByVille($ville)
    {
        return $this->where('ville', $ville)->findAll();
    }

    /**
     * Récupérer les villes uniques
     */
    public function getUniqueVilles()
    {
        $builder = $this->db->table('gares')
            ->select('DISTINCT ville')
            ->orderBy('ville', 'ASC');

        return $builder->get()->getResultArray();
    }
}
