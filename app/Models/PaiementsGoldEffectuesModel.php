<?php

namespace App\Models;

use CodeIgniter\Model;

class PaiementsGoldEffectuesModel extends Model
{
    protected $table = 'paiements_gold_effectues';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_utilisateur',
        'id_historique_remises_gold',
        'date_paiement'
    ];

    protected $validationRules = [
        'id_utilisateur' => 'required|integer|is_not_unique[utilisateurs.id]',
        'id_historique_remises_gold' => 'required|integer|is_not_unique[historique_remises_gold.id]',
    ];

    protected $validationMessages = [
        'id_utilisateur' => [
            'required' => 'L’utilisateur est obligatoire.',
            'integer' => 'ID utilisateur invalide.',
            'is_not_unique' => 'Cet utilisateur n’existe pas.'
        ],

        'id_historique_remises_gold' => [
            'required' => 'L’historique de remise est obligatoire.',
            'integer' => 'ID historique invalide.',
            'is_not_unique' => 'Cette remise GOLD n’existe pas.'
        ]
    ];

    public function isGold(int $idUtilisateur){
        return $this->where('id_utilisateur', $idUtilisateur)
                ->countAllResults() > 0;   
    }
}