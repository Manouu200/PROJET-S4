<?php

namespace App\Models;

use CodeIgniter\Model;

class CodeRechargeModel extends Model
{
    protected $table            = 'code_recharge';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'code',
        'montant',
        'est_utilise',
        'id_utilisateur',
        'created_at',
        'used_at',
    ];

    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';       // pas de updated_at dans la table
    protected $deletedField  = '';

    // Validation
    protected $validationRules = [
        'code'          => 'required|min_length[3]|max_length[100]|is_unique[code_recharge.code,id,{id}]',
        'montant'       => 'required|decimal|greater_than[0]',
        'est_utilise'   => 'permit_empty|in_list[0,1]',
        'id_utilisateur'=> 'permit_empty|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'code' => [
            'required'   => 'Le code est obligatoire.',
            'min_length' => 'Le code doit faire au moins 3 caracteres',
            'max_length' => 'Le code ne doit pas faire plus de 100 caracteres',
            'is_unique'  => 'Ce code existe deja.',
        ],
        'montant' => [
            'required'           => 'Le montant est obligatoire.',
            'decimal'            => 'Le montant doit etre un nombre.',
            'greater_than'       => 'Le montant doit etre superieur a 0',
        ],
        'est_utilise' => [
            'in_list'            => 'Le champ est_utilise est invalide.',
        ],
        'id_utilisateur' => [
            'is_natural_no_zero' => 'L utilisateur est invalide.',
        ],
    ];
}