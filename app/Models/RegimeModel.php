<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
    protected $table = 'regime';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'nom',
        'pourcent_viande',
        'pourcent_poisson',
        'pourcent_volaille',
        'poids_variation',
        'duree_jours',
    ];

    protected $validationRules = [
        'nom'               => 'required|min_length[3]|max_length[100]',
        'pourcent_viande'   => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
        'pourcent_poisson'  => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
        'pourcent_volaille' => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
        'poids_variation'   => 'required|decimal',
        'duree_jours'       => 'required|integer|greater_than[0]',
    ];

    protected $validationMessages = [
        'nom' => [
            'required'   => 'Le nom du régime est obligatoire.',
            'min_length' => 'Le nom doit contenir au moins 3 caractères.',
            'max_length' => 'Le nom ne doit pas dépasser 100 caractères.',
        ],

        'pourcent_viande' => [
            'required'              => 'Le pourcentage de viande est obligatoire.',
            'decimal'               => 'Le pourcentage de viande doit être un nombre.',
            'greater_than_equal_to' => 'Le pourcentage de viande doit être au moins 0.',
            'less_than_equal_to'    => 'Le pourcentage de viande ne peut pas dépasser 100.',
        ],

        'pourcent_poisson' => [
            'required'              => 'Le pourcentage de poisson est obligatoire.',
            'decimal'               => 'Le pourcentage de poisson doit être un nombre.',
            'greater_than_equal_to' => 'Le pourcentage de poisson doit être au moins 0.',
            'less_than_equal_to'    => 'Le pourcentage de poisson ne peut pas dépasser 100.',
        ],

        'pourcent_volaille' => [
            'required'              => 'Le pourcentage de volaille est obligatoire.',
            'decimal'               => 'Le pourcentage de volaille doit être un nombre.',
            'greater_than_equal_to' => 'Le pourcentage de volaille doit être au moins 0.',
            'less_than_equal_to'    => 'Le pourcentage de volaille ne peut pas dépasser 100.',
        ],

        'poids_variation' => [
            'required' => 'La variation de poids est obligatoire.',
            'decimal'  => 'La variation de poids doit être un nombre.',
        ],

        'duree_jours' => [
            'required'     => 'La durée est obligatoire.',
            'integer'      => 'La durée doit être un entier.',
            'greater_than' => 'La durée doit être supérieure à 0.',
        ],
    ];
}