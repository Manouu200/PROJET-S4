<?php

namespace App\Controllers;

use App\Models\Utilisateur;

class Auth extends BaseController
{
    public function authenticate()
    {
        $utilisateurModel = new Utilisateur();

        // Récupérer les données du formulaire
        $email = $this->request->getPost('email');
        $mot_de_passe = $this->request->getPost('mot_de_passe');

        // Chercher l'utilisateur par email
        $utilisateur = $utilisateurModel->where('email', $email)->first();

        // Vérifier si l'utilisateur existe et le mot de passe est correct
        if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
            // Stocker l'email en session
            session()->set('email', $email);

            // Afficher la page de succès
            return view('Success');
        } else {
            // Rediriger vers la page login avec un message d'erreur
            return redirect()->to(base_url('/'))
                ->with('error', 'Email ou mot de passe incorrect.');
        }
    }
}
