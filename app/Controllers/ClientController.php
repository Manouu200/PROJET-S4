<?php

namespace App\Controllers;

use App\Services\SoldeService;
use App\Services\GoldService;
use App\Libraries\Utils;
use App\Models\HistoriqueRemisesGoldModel;
use App\Models\HistoriqueSanteModel;
use App\Models\UtilisateurModel;
use App\Models\ObjectifModel;

class ClientController extends BaseController
{
    public function regimes()
    {
        $profil = $this->getRegimeProfil();
        $objectifModel = new ObjectifModel();

        return view('client/pages/regimes', [
            'utilisateur' => $profil['utilisateur'],
            'objectifs' => $objectifModel->getObjectifsOrdered(),
            'poids_actuel' => $profil['poids_actuel'],
            'taille_actuelle' => $profil['taille_actuelle'],
            'poids_ideal' => $profil['poids_ideal'],
            'poids_ideal_min' => $profil['poids_ideal_min'] ?? null,
            'poids_ideal_max' => $profil['poids_ideal_max'] ?? null,
        ]);
    }

    public function calculerObjectif()
    {
        if (! $this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Requête invalide.',
            ]);
        }

        $objectifId = (int) $this->request->getGet('objectif_id');
        $valeur = trim((string) $this->request->getGet('valeur'));

        $objectifModel = new ObjectifModel();
        $objectif = $objectifModel->getObjectifById($objectifId);
        if (! $objectif) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Objectif introuvable.',
            ]);
        }

        $profil = $this->getRegimeProfil();
        if ($profil['poids_actuel'] === null || $profil['taille_actuelle'] === null) {
            return $this->response->setStatusCode(422)->setJSON([
                'success' => false,
                'message' => 'Impossible de calculer sans poids et taille.',
            ]);
        }

        $poidsActuel = (float) $profil['poids_actuel'];
        $poidsIdeal = (float) $profil['poids_ideal'];
        $objectifLabel = (string) ($objectif['nom_objectif'] ?? 'Objectif');

        $inputLabel = null;
        $description = '';
        $targetWeight = null;
        $targetMin = null;
        $targetMax = null;

        // Accept explicit min/max if provided (user now inputs a desired interval)
        $minRaw = trim((string) $this->request->getGet('min'));
        $maxRaw = trim((string) $this->request->getGet('max'));

        if ($objectifId === 1) {
            $inputLabel = 'Plage de poids souhaitée (min — max)';
            $description = 'Choisissez une plage de poids cible (min et max).';

            if ($minRaw !== '' || $maxRaw !== '') {
                $min = $minRaw !== '' ? (float) str_replace(',', '.', $minRaw) : null;
                $max = $maxRaw !== '' ? (float) str_replace(',', '.', $maxRaw) : null;
                if ($min === null || $max === null || $min < 0 || $max < 0 || $min > $max) {
                    return $this->response->setStatusCode(422)->setJSON([
                        'success' => false,
                        'message' => 'Veuillez saisir une plage valide (min ≤ max).',
                    ]);
                }
                $targetMin = round($min, 1);
                $targetMax = round($max, 1);
            }
        } elseif ($objectifId === 2) {
            $inputLabel = 'Plage de poids souhaitée (min — max)';
            $description = 'Choisissez une plage de poids cible (min et max).';

            if ($minRaw !== '' || $maxRaw !== '') {
                $min = $minRaw !== '' ? (float) str_replace(',', '.', $minRaw) : null;
                $max = $maxRaw !== '' ? (float) str_replace(',', '.', $maxRaw) : null;
                if ($min === null || $max === null || $min < 0 || $max < 0 || $min > $max) {
                    return $this->response->setStatusCode(422)->setJSON([
                        'success' => false,
                        'message' => 'Veuillez saisir une plage valide (min ≤ max).',
                    ]);
                }
                $targetMin = round($min, 1);
                $targetMax = round($max, 1);
            }
        } elseif ($objectifId === 3) {
            $description = 'Plage de poids idéale selon votre taille (IMC 18.5–24.9).';
            // compute ideal interval from taille actuelle
            $taille = $profil['taille_actuelle'];
            if ($taille === null) {
                return $this->response->setStatusCode(422)->setJSON([
                    'success' => false,
                    'message' => 'Taille inconnue, impossible de calculer la plage idéale.',
                ]);
            }
            $interval = Utils::poidsIdealInterval((float) $taille);
            $targetMin = $interval['min'];
            $targetMax = $interval['max'];
        } else {
            return $this->response->setStatusCode(422)->setJSON([
                'success' => false,
                'message' => 'Cet objectif ne peut pas être calculé.',
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'objectif_id' => $objectifId,
            'objectif_label' => $objectifLabel,
            'input_label' => $inputLabel,
            'description' => $description,
            'current_weight' => $poidsActuel !== null ? round($poidsActuel, 1) : null,
            'ideal_weight' => $poidsIdeal !== null ? round($poidsIdeal, 1) : null,
            'target_min' => $targetMin,
            'target_max' => $targetMax,
            'needs_input' => in_array($objectifId, [1, 2], true),
        ]);
    }

    private function getRegimeProfil(): array
    {
        $userId = session()->get('user_id');
        $email = (string) session()->get('user_email');

        $utilisateurModel = new UtilisateurModel();
        $historiqueModel = new HistoriqueSanteModel();

        if (empty($userId) && $email !== '') {
            $userId = $utilisateurModel->getIdByEmail($email);
        }

        $userId = $userId ? (int) $userId : null;
        $user = $userId ? $utilisateurModel->find($userId) : null;
        $derniereMesure = $userId ? $historiqueModel->getDerniereMesureByUserId($userId) : null;

        $poids = $derniereMesure['poids'] ?? null;
        $taille = $derniereMesure['taille'] ?? null;
        $imc = ($poids !== null && $taille !== null) ? Utils::calculerIMC((float) $poids, (float) $taille) : null;

        $poidsIdeal = $taille !== null ? Utils::poidsIdeal((float) $taille) : null;
        $poidsIdealInterval = $taille !== null ? Utils::poidsIdealInterval((float) $taille) : null;

        return [
            'utilisateur' => $user ? array_merge($user, [
                'poids' => $poids,
                'taille' => $taille,
                'imc' => $imc,
            ]) : null,
            'poids_actuel' => $poids !== null ? (float) $poids : null,
            'taille_actuelle' => $taille !== null ? (float) $taille : null,
            'poids_ideal' => $poidsIdeal,
            'poids_ideal_min' => $poidsIdealInterval['min'] ?? null,
            'poids_ideal_max' => $poidsIdealInterval['max'] ?? null,
        ];
    }

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

        $userId = session()->get('user_id');
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
        } else if ($page === 'gold') {
            $goldService = new GoldService();
            if ($goldService->isGold($userId)) {
                $data['peut_acheter'] = false;
            } else {
                $data['peut_acheter'] = true;
                $data['prixGold'] = (new HistoriqueRemisesGoldModel())->getInfosActuelGold()['prix'];
            }
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

        // Calcul des poids idéaux
        $poidsIdealInterval = $taille ? Utils::poidsIdealInterval((float) $taille) : null;
        $poidsIdeal = $taille ? Utils::poidsIdeal((float) $taille) : null;

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
            'poids_ideal_min' => $poidsIdealInterval['min'] ?? 0,
            'poids_ideal_max' => $poidsIdealInterval['max'] ?? 0,
            'poids_ideal' => $poidsIdeal,
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
