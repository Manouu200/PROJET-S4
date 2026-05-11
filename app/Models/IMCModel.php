<?php

namespace App\Models;

use CodeIgniter\Model;

class IMCModel extends Model
{
    protected $table = 'imc';
    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'min',
        'max',
        'libelle',
    ];
}
