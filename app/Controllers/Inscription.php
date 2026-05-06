<?php

namespace App\Controllers;

use App\Models\Utilisateur;
use App\Models\HistoriqueSante;

class Inscription extends BaseController
{
    public function etape1(): string
    {
        return view('Inscription_etape1');
    }

    public function etape2(): string
    {
        // Stocker les données de l'étape 1 en session
        session()->set([
            'nom' => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'date_naissance' => $this->request->getPost('date_naissance'),
            'genre' => $this->request->getPost('genre'),
            'email' => $this->request->getPost('email'),
            'mot_de_passe' => $this->request->getPost('mot_de_passe'),
        ]);

        return view('Inscription_etape2');
    }

    public function finaliser()
    {
        $utilisateurModel = new Utilisateur();
        $historiqueSanteModel = new HistoriqueSante();

        // Récupérer les données du formulaire
        $nom = $this->request->getPost('nom');
        $prenom = $this->request->getPost('prenom');
        $date_naissance = $this->request->getPost('date_naissance');
        $genre = $this->request->getPost('genre');
        $email = $this->request->getPost('email');
        $mot_de_passe = $this->request->getPost('mot_de_passe');
        $taille = $this->request->getPost('taille');
        $poids = $this->request->getPost('poids');

        // Insérer l'utilisateur
        $utilisateurData = [
            'nom' => $nom,
            'prenom' => $prenom,
            'date_naissance' => $date_naissance,
            'genre' => $genre,
            'email' => $email,
            'mot_de_passe' => password_hash($mot_de_passe, PASSWORD_DEFAULT),
            'role' => 'CLIENT'
        ];

        $idUtilisateur = $utilisateurModel->insert($utilisateurData);

        // Stocker l'email en session
        session()->set('email', $email);

        // Chercher l'id de l'utilisateur avec cet email
        $utilisateur = $utilisateurModel->where('email', $email)->first();
        $idUtilisateurFromDb = $utilisateur['id'];

        // Insérer l'historique de santé avec la date d'inscription
        $historiqueSanteData = [
            'id_utilisateur' => $idUtilisateurFromDb,
            'poids' => $poids,
            'taille' => $taille,
            'date_mesure' => date('Y-m-d')
        ];

        $historiqueSanteModel->insert($historiqueSanteData);

        // Afficher la page de succès
        return view('Success');
    }

    public function reset()
    {
        // Supprimer les données de session
        session()->remove('nom');
        session()->remove('prenom');
        session()->remove('date_naissance');
        session()->remove('genre');
        session()->remove('email');
        session()->remove('mot_de_passe');

        // Rediriger vers l'accueil
        return redirect()->to(base_url('/'));
    }
}
