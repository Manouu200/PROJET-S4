<?php

namespace App\Controllers;

use App\Services\SoldeService;
use App\Libraries\Utils;
use App\Models\HistoriqueSanteModel;
use App\Models\UtilisateurModel;

class ClientController extends BaseController
{
    public function index()
    {
        $data = [
            'user_nom' => session()->get('user_nom'),
        ];
        return view('client/home', $data);
    }


    public function page(string $page)
    {
        $allowedPages = [
            'accueil' => 'client/pages/acceuil',
            'regimes' => 'client/pages/regimes',
            'programme' => 'client/pages/programme',
            'solde' => 'client/pages/solde',
            'gold' => 'client/pages/gold',
        ];

        if (! array_key_exists($page, $allowedPages)) {
            return $this->response->setStatusCode(404);
        }

        $data = [];

        switch ($page) {
            case 'solde':

            default:
                # code...
                break;
        }

        // If accueil, compute IMC server-side and pass to view (no model calls in views)
        if ($page === 'accueil') {
            $imc = null;
            $userId = session()->get('user_id');
            $utilisateurModel = new UtilisateurModel();
            $historiqueModel = new HistoriqueSanteModel();

            if (empty($userId)) {
                $email = (string) session()->get('user_email');
                if ($email !== '') {
                    $userId = $utilisateurModel->getIdByEmail($email);
                }
            }

            if ($userId) {
                $dern = $historiqueModel->getDerniereMesureByUserId((int) $userId);
                $poids = $dern['poids'] ?? null;
                $taille = $dern['taille'] ?? null;
                $imc = ($poids !== null && $taille !== null) ? Utils::calculerIMC((float) $poids, (float) $taille) : null;
            }

            return view($allowedPages[$page], ['imc' => $imc]);
        } else if ($page === 'solde') {
            $service = new SoldeService();
            $data['solde'] = $service->getSoldeUtilisateur(session()->get('user_id'));

            return view($allowedPages[$page], $data);
        }
        return view($allowedPages[$page]);
    }

    public function edit()
    {
        $email = (string) session()->get('user_email');
        $utilisateurModel = new UtilisateurModel();
        $historiqueModel = new HistoriqueSanteModel();

        $userId = session()->get('user_id');
        if (empty($userId) && $email !== '') {
            $userId = $utilisateurModel->getIdByEmail($email);
        }

        $userId = $userId ? (int) $userId : null;
        $user = $userId ? $utilisateurModel->find($userId) : null;
        $derniereMesure = $userId ? $historiqueModel->getDerniereMesureByUserId($userId) : null;

        $poids = $derniereMesure['poids'] ?? null;
        $taille = $derniereMesure['taille'] ?? null;
        $imc = ($poids !== null && $taille !== null) ? Utils::calculerIMC((float) $poids, (float) $taille) : null;

        $data = [
            'user' => $user,
            'user_nom' => $user['nom'] ?? session()->get('user_nom'),
            'user_prenom' => $user['prenom'] ?? '',
            'user_date_naissance' => $user['date_naissance'] ?? '',
            'user_genre' => $user['genre'] ?? '',
            'user_email' => $user['email'] ?? $email,
            'user_password' => '',
            'user_id' => $userId,
            'derniere_mesure' => $derniereMesure,
            'poidsDerniereMesure' => isset($derniereMesure['poids']) ? (string) $derniereMesure['poids'] : '',
            'tailleDerniereMesure' => isset($derniereMesure['taille']) ? (string) $derniereMesure['taille'] : '',
            'imc' => $imc,
            'imc_categorie' => $imc !== null ? Utils::categorieIMC((float) $imc) : null,
        ];

        // Prepare flash HTML to avoid business logic in views
        $session = session();
        $flashError = $session->getFlashdata('error');
        $flashSuccess = $session->getFlashdata('success');
        $flashErrors = $session->getFlashdata('errors') ?? [];
        $wizardStep = $session->getFlashdata('wizard_step') ?? 1;

        $flashHtml = '';
        if (is_string($flashError) && $flashError !== '') {
            $flashHtml .= '<div class="alert alert-danger">' . esc($flashError) . '</div>';
        }
        if (is_string($flashSuccess) && $flashSuccess !== '') {
            $flashHtml .= '<div class="alert alert-success">' . esc($flashSuccess) . '</div>';
        }
        if (!empty($flashErrors) && is_array($flashErrors)) {
            $flashHtml .= '<div class="alert alert-danger">';
            foreach ($flashErrors as $err) {
                $errText = is_scalar($err) ? (string) $err : '';
                if ($errText !== '') {
                    $flashHtml .= '<div>' . esc($errText) . '</div>';
                }
            }
            $flashHtml .= '</div>';
        }

        $data['flashHtml'] = $flashHtml;
        $data['wizard_step'] = (int) $wizardStep;

        return view('client/pages/edit', $data);
    }

    public function update()
    {
        $userId = session()->get('user_id');
        $emailSession = (string) session()->get('user_email');

        if (empty($userId) && $emailSession !== '') {
            $userModel = new UtilisateurModel();
            $userId = $userModel->getIdByEmail($emailSession);
        }

        $userId = $userId ? (int) $userId : null;
        if (! $userId) {
            return redirect()->to('/login');
        }

        $rules = [
            'nom' => 'required|min_length[2]|max_length[100]',
            'prenom' => 'required|min_length[2]|max_length[100]',
            'date_naissance' => 'required|valid_date',
            'genre' => 'required|in_list[M,F,AUTRE]',
            'email' => 'required|valid_email|max_length[150]',
            'mot_de_passe' => 'permit_empty|min_length[6]',
            'poids' => 'required|numeric|greater_than_equal_to[20]|less_than_equal_to[300]',
            'taille' => 'required|numeric|greater_than_equal_to[50]|less_than_equal_to[250]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('wizard_step', 2);
        }

        $userModel = new UtilisateurModel();
        $historiqueModel = new HistoriqueSanteModel();

        $email = trim((string) $this->request->getPost('email'));
        $existingUser = $userModel->where('email', $email)->first();
        if ($existingUser && (int) $existingUser['id'] !== $userId) {
            return redirect()->back()->withInput()->with('error', 'Cet email est déjà utilisé.');
        }

        $dataUser = [
            'nom' => trim((string) $this->request->getPost('nom')),
            'prenom' => trim((string) $this->request->getPost('prenom')),
            'date_naissance' => $this->request->getPost('date_naissance') ?: null,
            'genre' => $this->request->getPost('genre'),
            'email' => $email,
        ];

        $motDePasse = trim((string) $this->request->getPost('mot_de_passe'));
        if ($motDePasse !== '') {
            $dataUser['mot_de_passe'] = password_hash($motDePasse, PASSWORD_DEFAULT);
        }

        $poids = (float) $this->request->getPost('poids');
        $taille = (float) $this->request->getPost('taille');

        $db = \Config\Database::connect();
        $db->transStart();

        $userModel->update($userId, $dataUser);
        $historiqueModel->insert([
            'id_utilisateur' => $userId,
            'poids' => $poids,
            'taille' => $taille,
            'date_mesure' => date('Y-m-d'),
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'La mise à jour a échoué.')->with('wizard_step', 2);
        }

        session()->set([
            'user_id' => $userId,
            'user_nom' => $dataUser['nom'],
            'user_email' => $dataUser['email'],
        ]);

        return redirect()->to('/client/home')->with('success', 'Profil mis à jour avec succès.');
    }
}
