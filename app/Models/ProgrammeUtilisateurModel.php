<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgrammeUtilisateurModel extends Model
{
    protected $table = 'programme_utilisateur';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = [
        'id_utilisateur',
        'id_regime',
        'id_activite',
        'date_decision',
    ];

    public function getProgrammesUtilisateur(int $userId): array
    {
        // Select programme fields plus useful regime data (percentages, poids variation, duree)
        return $this->select(
            'programme_utilisateur.*,' .
                ' regime.nom AS regime_nom,' .
                ' regime.pourcent_viande AS pourcent_viande,' .
                ' regime.pourcent_poisson AS pourcent_poisson,' .
                ' regime.pourcent_volaille AS pourcent_volaille,' .
                ' regime.poids_variation AS poids_variation,' .
                ' regime.duree_jours AS duree_regime,' .
                ' activite_sportive.nom AS activite_nom'
        )
            ->join('regime', 'regime.id = programme_utilisateur.id_regime', 'left')
            ->join('activite_sportive', 'activite_sportive.id = programme_utilisateur.id_activite', 'left')
            ->where('programme_utilisateur.id_utilisateur', $userId)
            ->orderBy('programme_utilisateur.date_decision', 'DESC')
            ->findAll();
    }
}
