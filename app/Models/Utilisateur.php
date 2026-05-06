<?php

namespace App\Models;

use CodeIgniter\Model;

class Utilisateur extends Model
{
    protected $table = 'utilisateurs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nom', 'prenom', 'date_naissance', 'genre', 'email', 'mot_de_passe', 'est_gold', 'role'];
    protected $useTimestamps = false;
}
