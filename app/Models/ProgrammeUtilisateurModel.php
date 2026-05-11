<?php
namespace App\Models;

use CodeIgniter\Model;

class ProgrammeUtilisateurModel extends Model
{
    protected $table = 'programme_utilisateur';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_utilisateur',
        'id_regime',
        'id_activite',
        'date_decision',
    ];
    public $timestamps = false;
}
