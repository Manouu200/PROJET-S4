<?php

namespace App\Models;

use CodeIgniter\Model;

class ObjectifModel extends Model
{
    protected $table = 'objectif';
    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'nom_objectif',
    ];

    public function getObjectifsOrdered(): array
    {
        return $this->orderBy('id', 'ASC')->findAll() ?: [];
    }

    public function getObjectifById(int $objectifId): ?array
    {
        $objectif = $this->find($objectifId);

        return is_array($objectif) ? $objectif : null;
    }
}
