<?php

namespace App\Models;

use CodeIgniter\Model;

class PortefeuilleModel extends Model
{
    // ok
    protected $table            = 'portefeuille';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    protected $allowedFields = [
        'id_utilisateur',
        'solde',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'id_utilisateur' => 'required|is_natural_no_zero',
        'solde'          => 'permit_empty|decimal|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'id_utilisateur' => [
            'required'           => 'L utilisateur est obligatoire.',
            'is_natural_no_zero' => 'L utilisateur est invalide.',
        ],
        'solde' => [
            'decimal'                => 'Le solde doit etre un nombre.',
            'greater_than_equal_to'  => 'Le solde ne peut pas etre negatif.',
        ],
    ];
}
