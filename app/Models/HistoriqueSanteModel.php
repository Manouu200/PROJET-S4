<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoriqueSanteModel extends Model
{
    protected $table = 'historique_sante';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_utilisateur', 'poids', 'taille', 'date_mesure'];
    protected $useTimestamps = false;

    public function getDerniereMesureByUserId(int $userId): ?array
    {
        return $this->where('id_utilisateur', $userId)
            ->orderBy('date_mesure', 'DESC')
            ->orderBy('id', 'DESC')
            ->first();
    }
}
