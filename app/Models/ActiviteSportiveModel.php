<?php

namespace App\Models;

use CodeIgniter\Model;

class ActiviteSportiveModel extends Model
{
    protected $table = 'activite_sportive';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = [
        'nom',
        'poids_variation',
    ];

    protected $validationRules = [
        'nom' => 'required|min_length[2]|max_length[100]|is_unique[activite_sportive.nom]',
        'poids_variation' => 'required|decimal',
    ];

    protected $validationMessages = [
        'nom' => [
            'required'   => 'Le nom de l’activité sportive est obligatoire.',
            'min_length' => 'Le nom doit contenir au moins 2 caractères.',
            'max_length' => 'Le nom ne doit pas dépasser 100 caractères.',
            'is_unique'  => 'Cette activité sportive existe déjà.',
        ],

        'poids_variation' => [
            'required' => 'La variation de poids est obligatoire.',
            'decimal'  => 'La variation de poids doit être un nombre valide.',
        ],
    ];


    public function getAllActivites(): array {
        return $this->orderBy('nom', 'ASC')->findAll();
    }

    /**
     * Retourne les activités favorisant une prise de poids
     */
    public function getActivitesPrisePoids(): array
    {
        return $this->where('poids_variation >', 0)
                    ->orderBy('poids_variation', 'DESC')
                    ->findAll();
    }

    /**
     * Retourne les activités favorisant une perte de poids
     */
    public function getActivitesPertePoids(): array
    {
        return $this->where('poids_variation <', 0)
                    ->orderBy('poids_variation', 'ASC')
                    ->findAll();
    }
}