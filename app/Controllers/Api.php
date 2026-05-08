<?php

namespace App\Controllers;

use App\Models\Utilisateur;

class Api extends BaseController
{
    public function checkEmail()
    {
        $email = $this->request->getPost('email');

        if (empty($email)) {
            return $this->response->setJSON(['exists' => false]);
        }

        $utilisateurModel = new Utilisateur();
        $utilisateur = $utilisateurModel->where('email', $email)->first();

        return $this->response->setJSON(['exists' => $utilisateur ? true : false]);
    }
}
