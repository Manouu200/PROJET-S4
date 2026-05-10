<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoriqueRemisesGoldModel extends Model
{
    protected $table = 'historique_remises_gold';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'prix',
        'pourcent_remise',
        'created_at'
    ];

    protected $validationRules = [
        'prix' => 'required|decimal|greater_than[0]',
        'pourcent_remise' => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
    ];

    protected $validationMessages = [
        'prix' => [
            'required' => 'Le prix est obligatoire.',
            'decimal' => 'Le prix doit être un nombre décimal valide.',
            'greater_than' => 'Le prix doit être supérieur à 0.'
        ],

        'pourcent_remise' => [
            'required' => 'Le pourcentage de remise est obligatoire.',
            'decimal' => 'Le pourcentage doit être valide.',
            'greater_than_equal_to' => 'La remise ne peut pas être négative.',
            'less_than_equal_to' => 'La remise ne peut pas dépasser 100%.'
        ]
    ];
}