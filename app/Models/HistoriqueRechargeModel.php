<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoriqueRechargeModel extends Model
{
    protected $table            = 'historique_recharge';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_portefeuille',
        'id_code_utilise',
        'montant',
        'used_at',
    ];

    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = false; // used_at est gere par la DB
    protected $dateFormat    = 'datetime';
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField  = '';

    // Validation
    protected $validationRules = [
        'id_portefeuille' => 'required|is_natural_no_zero',
        'id_code_utilise' => 'required|is_natural_no_zero|is_unique[historique_recharge.id_code_utilise,id,{id}]',
        'montant'         => 'required|decimal|greater_than[0]',
        'used_at'         => 'permit_empty|valid_date',
    ];

    protected $validationMessages = [
        'id_portefeuille' => [
            'required'           => 'Le portefeuille est obligatoire.',
            'is_natural_no_zero' => 'Le portefeuille est invalide.',
        ],
        'id_code_utilise' => [
            'required'           => 'Le code utilise est obligatoire.',
            'is_natural_no_zero' => 'Le code utilise est invalide.',
            'is_unique'          => 'Ce code a deja ete utilise.',
        ],
        'montant' => [
            'required'      => 'Le montant est obligatoire.',
            'decimal'       => 'Le montant doit etre un nombre.',
            'greater_than'  => 'Le montant doit etre superieur a 0.',
        ],
        'used_at' => [
            'valid_date'    => 'La date est invalide.',
        ],
    ];
}