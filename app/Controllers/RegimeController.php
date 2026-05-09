<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RegimeModel;
use App\Models\RegimePrixModel;

class RegimeController extends BaseController
{
    public function index()
    {
        $regimeModel = new \App\Models\RegimeModel();
        $data['regimes'] = $regimeModel->findAll();

        return view('admin/regimes/index.php', $data);
    }
    public function create()
    {
        return view('admin/regimes/create');
    }

    public function store()
    {
        $regimeModel = new RegimeModel();
        $prixModel = new RegimePrixModel();
        $db = \Config\Database::connect();

        $nom = trim($this->request->getPost('nom'));
        $poids = (float)$this->request->getPost('poids_variation');
        $viande = (int)$this->request->getPost('pourcent_viande');
        $poisson = (int)$this->request->getPost('pourcent_poisson');
        $volaille = (int)$this->request->getPost('pourcent_volaille');

        $durees = $this->request->getPost('prix_duree'); 
        $prix = $this->request->getPost('prix_valeur');  

        
        $durees = array_map('intval', $durees);
        $prix = array_map('floatval', $prix);

        
        if (($viande + $poisson + $volaille) != 100) {
            return redirect()->back()->withInput()->with('error', 'La somme des pourcentages doit être égale à 100%.');
        }

        try {
            $db->transStart(); 

            $dataRegime = [
                'nom'               => $nom,
                'pourcent_viande'   => $viande,
                'pourcent_poisson'  => $poisson,
                'pourcent_volaille' => $volaille,
                'poids_variation'   => $poids,
                'duree_jours'       => $durees[0] 
            ];

            if (!$regimeModel->insert($dataRegime)) {
                $errors = $regimeModel->errors();
                $errorMsg = "Erreur lors de l'insertion du régime: ";
                if (!empty($errors)) {
                    foreach ($errors as $field => $error) {
                        $errorMsg .= "$field - $error | ";
                    }
                } else {
                    $errorMsg .= "Vérifiez les données du formulaire.";
                }
                throw new \Exception($errorMsg);
            }

            $idRegime = $db->insertID();

            if (!empty($durees) && count($durees) == count($prix)) {
                for ($i = 0; $i < count($durees); $i++) {
                    $dataPrix = [
                        'id_regime'   => $idRegime,
                        'duree_jours' => $durees[$i],
                        'prix'        => $prix[$i]
                    ];

                    if (!$prixModel->insert($dataPrix)) {
                        throw new \Exception("Erreur lors de l'insertion du prix pour la durée " . $durees[$i]);
                    }
                }
            }

            $db->transComplete(); 

            if ($db->transStatus() === false) {
                return redirect()->back()->withInput()->with('error', 'Une erreur est survenue lors de l\'enregistrement.');
            }

            return redirect()->to('/admin/regimes')->with('success', 'Le régime "' . $nom . '" a été créé avec succès !');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit($id = null)
    {
        if (!$id) {
            return redirect()->to('/admin/regimes')->with('error', 'Régime introuvable.');
        }

        $regimeModel = new RegimeModel();
        $prixModel = new RegimePrixModel();

        $data['regime'] = $regimeModel->find($id);
        if (!$data['regime']) {
            return redirect()->to('/admin/regimes')->with('error', 'Régime introuvable.');
        }

        $data['prix'] = $prixModel->where('id_regime', $id)->findAll();

        return view('admin/regimes/edit', $data);
    }

    public function update($id = null)
    {
        if (!$id) {
            return redirect()->to('/admin/regimes')->with('error', 'Régime introuvable.');
        }

        $regimeModel = new RegimeModel();
        $prixModel = new RegimePrixModel();
        $db = \Config\Database::connect();

        $nom = trim($this->request->getPost('nom'));
        $poids = (float)$this->request->getPost('poids_variation');
        $viande = (int)$this->request->getPost('pourcent_viande');
        $poisson = (int)$this->request->getPost('pourcent_poisson');
        $volaille = (int)$this->request->getPost('pourcent_volaille');

        $durees = $this->request->getPost('prix_duree');
        $prix = $this->request->getPost('prix_valeur');

        $durees = array_map('intval', $durees);
        $prix = array_map('floatval', $prix);

        if (($viande + $poisson + $volaille) != 100) {
            return redirect()->back()->withInput()->with('error', 'La somme des pourcentages doit être égale à 100%.');
        }

        try {
            $db->transStart();

            $dataRegime = [
                'nom'               => $nom,
                'pourcent_viande'   => $viande,
                'pourcent_poisson'  => $poisson,
                'pourcent_volaille' => $volaille,
                'poids_variation'   => $poids,
                'duree_jours'       => $durees[0]
            ];

            if (!$regimeModel->update($id, $dataRegime)) {
                $errors = $regimeModel->errors();
                $errorMsg = "Erreur lors de la modification du régime: ";
                if (!empty($errors)) {
                    foreach ($errors as $field => $error) {
                        $errorMsg .= "$field - $error | ";
                    }
                } else {
                    $errorMsg .= "Vérifiez les données du formulaire.";
                }
                throw new \Exception($errorMsg);
            }

            // Supprimer les anciens prix
            $prixModel->where('id_regime', $id)->delete();

            // Ajouter les nouveaux prix
            if (!empty($durees) && count($durees) == count($prix)) {
                for ($i = 0; $i < count($durees); $i++) {
                    $dataPrix = [
                        'id_regime'   => $id,
                        'duree_jours' => $durees[$i],
                        'prix'        => $prix[$i]
                    ];

                    if (!$prixModel->insert($dataPrix)) {
                        throw new \Exception("Erreur lors de l'insertion du prix pour la durée " . $durees[$i]);
                    }
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->withInput()->with('error', 'Une erreur est survenue lors de l\'enregistrement.');
            }

            return redirect()->to('/admin/regimes')->with('success', 'Le régime "' . $nom . '" a été modifié avec succès !');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function delete($id = null)
    {
        if (!$id) {
            return redirect()->to('/admin/regimes')->with('error', 'Régime introuvable.');
        }

        $regimeModel = new RegimeModel();
        $prixModel = new RegimePrixModel();
        $db = \Config\Database::connect();

        try {
            $db->transStart();

            // Récupérer le nom du régime avant suppression
            $regime = $regimeModel->find($id);
            if (!$regime) {
                throw new \Exception('Régime introuvable');
            }

            $nom = $regime['nom'];

            // Supprimer les prix associés
            $prixModel->where('id_regime', $id)->delete();

            // Supprimer le régime
            if (!$regimeModel->delete($id)) {
                throw new \Exception('Erreur lors de la suppression du régime');
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->to('/admin/regimes')->with('error', 'Une erreur est survenue lors de la suppression.');
            }

            return redirect()->to('/admin/regimes')->with('success', 'Le régime "' . $nom . '" a été supprimé avec succès !');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/admin/regimes')->with('error', $e->getMessage());
        }
    }
}
