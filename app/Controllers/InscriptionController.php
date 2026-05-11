<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;
use App\Models\HistoriqueSanteModel;

class InscriptionController extends BaseController
{
    public function inscription_etape1()
    {
        if ($this->request->getGet('from') === 'login') {
            session()->remove(['nom', 'prenom', 'email', 'genre', 'mot_de_passe', 'date_naissance']);
        }
        return view('inscription_etape1');
    }

    public function inscription_etape2()
    {
        $dataStep1 = $this->request->getPost();
        
        session()->set($dataStep1);

        return view('inscription_etape2');
    }

    public function finaliser()
    {
        $db = \Config\Database::connect();
        $utilisateurModel = new UtilisateurModel();
        $santeModel = new HistoriqueSanteModel();

        try {
            $db->transStart();

            $userdata = [
                'nom'            => session()->get('nom'),
                'prenom'         => session()->get('prenom'),
                'email'          => session()->get('email'),
                'genre'          => session()->get('genre'),
                'mot_de_passe'   => password_hash(session()->get('mot_de_passe'), PASSWORD_DEFAULT),
                'date_naissance' => session()->get('date_naissance'),
                'role'           => 'CLIENT',
                'est_gold'       => FALSE
            ];

            if (!$utilisateurModel->insert($userdata)) {
                $err = implode(' | ', $utilisateurModel->errors());
                throw new \Exception("Erreur Profil : " . $err);
            }

            $newUserId = $db->insertID();

            $taille = $this->request->getPost('taille');
            $poids = $this->request->getPost('poids');

            $santeData = [
                'id_utilisateur' => $newUserId,
                'taille'         => (float)$taille ,
                'poids'          => (float)$poids,
                'date_mesure'    => date('Y-m-d')
            ];

            if (!$santeModel->insert($santeData)) {
                $err = implode(' | ', $santeModel->errors());
                throw new \Exception("Erreur Santé : " . $err);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception("Erreur lors de la transaction SQL finale.");
            }

            $newUser = $utilisateurModel->find($newUserId);

            session()->remove(['nom', 'prenom', 'email', 'genre', 'mot_de_passe', 'date_naissance']);

            session()->set([
                'user_id'    => $newUser['id'],
                'user_role'  => 'client', 
                'user_nom'   => $newUser['nom'],
                'isLoggedIn' => true
            ]);

            return redirect()->to('/client/home');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/inscription/etape1')->with('error', $e->getMessage());
        }
    }
}