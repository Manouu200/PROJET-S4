<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RegimeModel;
use App\Models\RegimePrixModel;

class RegimeController extends BaseController
{
    public function create()
    {
        return view('admin/regimes/create');
    }

    public function store()
    {
        $regimeModel = new RegimeModel();
        $prixModel = new RegimePrixModel();
        $db = \Config\Database::connect();

        // 1. Récupération des données simples
        $nom = trim($this->request->getPost('nom'));
        $poids = (float)$this->request->getPost('poids_variation');
        $viande = (int)$this->request->getPost('pourcent_viande');
        $poisson = (int)$this->request->getPost('pourcent_poisson');
        $volaille = (int)$this->request->getPost('pourcent_volaille');

        // 2. Récupération des tableaux dynamiques (Prix/Durée)
        $durees = $this->request->getPost('prix_duree'); // Array
        $prix = $this->request->getPost('prix_valeur');   // Array
        
        // Conversion des tableaux en entiers/float
        $durees = array_map('intval', $durees);
        $prix = array_map('floatval', $prix);

        // Validation rapide de la somme des pourcentages (Sécurité côté serveur)
        if (($viande + $poisson + $volaille) != 100) {
            return redirect()->back()->withInput()->with('error', 'La somme des pourcentages doit être égale à 100%.');
        }

        try {
            $db->transStart(); // Début de la transaction

            // 3. Insertion du Régime
            $dataRegime = [
                'nom'               => $nom,
                'pourcent_viande'   => $viande,
                'pourcent_poisson'  => $poisson,
                'pourcent_volaille' => $volaille,
                'poids_variation'   => $poids,
                'duree_jours'       => $durees[0] // On met la première durée comme durée de référence
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

            // 4. Insertion des tarifs associés
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

            $db->transComplete(); // Fin de la transaction

            if ($db->transStatus() === false) {
                return redirect()->back()->withInput()->with('error', 'Une erreur est survenue lors de l\'enregistrement.');
            }

            return redirect()->to('/admin/regimes')->with('success', 'Le régime "' . $nom . '" a été créé avec succès !');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}