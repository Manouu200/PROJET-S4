<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimePrixModel extends Model
{
    protected $table = 'regime_prix';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    
    protected $allowedFields = [
        'id_regime',
        'duree_jours',
        'prix',
    ];

    protected $validationRules = [
        'id_regime'   => 'required|is_not_unique[regime.id]',
        'duree_jours' => 'required|integer|greater_than[0]',
        'prix'        => 'required|decimal|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'id_regime' => [
            'required'      => 'Le régime associé est obligatoire.',
            'is_not_unique' => 'Le regime selectionne n\'existe pas en base de donnees'
        ],

        'duree_jours' => [
            'required'     => 'La durée est obligatoire.',
            'integer'      => 'La durée doit être un nombre entier.',
            'greater_than' => 'La durée doit être supérieure à 0.',
        ],

        'prix' => [
            'required'              => 'Le prix est obligatoire.',
            'decimal'               => 'Le prix doit être un nombre valide.',
            'greater_than_equal_to' => 'Le prix ne peut pas être négatif.',
        ],
    ];


    /**
     * =========================
     * MÉTHODES PERSONNALISÉES
     * =========================
     */

    public function getPrixDeRegime(int $idRegime)
    {
        return $this->where('id_regime', $idRegime)
                    ->orderBy('duree_jours', 'ASC')
                    ->findAll();
    }

    /**
     * Récupère les prix avec les infos du régime (JOIN)
     */
    public function getPrixWithRegime()
    {
        return $this->select('regime_prix.*, regime.nom')
                    ->join('regime', 'regime.id = regime_prix.id_regime')
                    ->findAll();
    }

}