<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;
use CodeIgniter\Database\Database;
use App\Models\HistoriqueSanteModel;

class InscriptionController extends BaseController
{

    public function inscription_etape1()
    {
        return view('inscription_etape1');
    }

    public function inscription_etape2()
    {
        $data = $this->request->getPost();

        session()->set($data);

        return view('inscription_etape2');
    }

    public function finaliser()
    {

        $db = \Config\Database::connect();
        $utilisateurModel = new UtilisateurModel();
        $santeModel = new HistoriqueSanteModel();

        $db->transStart();

        $userdata = [
            'nom'           => session()->get('nom'),
            'prenom'        => session()->get('prenom'),
            'email'         => session()->get('email'),
            'genre'         => session()->get('genre'),
            'mot_de_passe'  => password_hash(session()->get('mot_de_passe'), PASSWORD_DEFAULT),
            'taille'        => $this->request->getPost('taille'),
            'poids'         => $this->request->getPost('poids'),
            'role'          => 'client',
            'porte_monnaie' => 0,
            'est_gold'      => 0
        ];

        $utilisateurModel->insert($userdata);
        $newUserId = $db->insertID();

        $santeData = [
            'utilisateur_id' => $newUserId,
            'taille'         => $userdata['taille'],
            'poids'          => $userdata['poids'],
            'date_mesure' => date('Y-m-d H:i:s')
        ];
        $santeModel->insert($santeData);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', "Erreur lors de la création du profil.");
        }

        session()->remove(['nom', 'prenom', 'email', 'genre', 'mot_de_passe']);
        return redirect()->to('/login')->with('success', "Inscription réussie !");
    }


    public function checkEmail()
    {
        $email = $this->request->getPost('email');
        $model = new UtilisateurModel();
        $user = $model->where('email', $email)->first();

        return $this->response->setJSON([
            'exists' => ($user !== null)
        ]);
    }
}
