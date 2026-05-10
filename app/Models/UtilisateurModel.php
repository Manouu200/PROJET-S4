<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = 'utilisateurs';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nom', 'prenom', 'date_naissance', 'genre', 'email', 'mot_de_passe', 'est_gold', 'role', 'porte_monnaie'];
    protected $useTimestamps = false;

    public function login($email, $password)
    {
        $user = $this->where('email', $email)->first();
        if ($user && password_verify($password, $user['mot_de_passe'])) {
            return $user;
        }
        return null;
    }

    public function getNombresClients()
    {
        return $this->where('role', 'CLIENT')->countAllResults();
    }

    public function getNombresClientsGold()
    {
        return $this->where('role', 'CLIENT')->where('est_gold', true)->countAllResults();
    }

    public function getIdByEmail(string $email): ?int
    {
        $user = $this->select('id')->where('email', $email)->first();

        return $user ? (int) $user['id'] : null;
    }
}
