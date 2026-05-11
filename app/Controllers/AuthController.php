<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;

class AuthController extends BaseController
{

    public function login()
    {
        return view('login');
    }

    public function authenticate()
    {
        $model = new UtilisateurModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('mot_de_passe');

        $user = $model->login($email, $password);

        if ($user) {
            session()->set([
                'user_id'    => $user['id'],
                'user_email' => $user['email'],
                'user_role'  => strtolower($user['role']),
                'user_nom'   => $user['nom'],
                'isLoggedIn' => true
            ]);

            return (strtolower($user['role']) === 'admin')
                ? redirect()->to('/admin/dashboard') 
                : redirect()->to('/client/home');
        }

        return redirect()->back()->with('error', 'Identifiants invalides');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
