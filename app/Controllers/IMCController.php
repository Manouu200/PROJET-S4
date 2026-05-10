<?php

namespace App\Controllers; 

use App\Controllers\BaseController;
use App\Models\IMCModel;

class IMCController extends BaseController
{
    // Liste toutes les tranches
    public function index()
    {
        $model = new IMCModel();
        $data = [
            'categories' => $model->orderBy('min', 'ASC')->findAll(),
            'title'      => 'Gestion IMC'
        ];
        return view('admin/imc/index', $data);
    }

    // Affiche le formulaire de création
    public function create()
    {
        $data = ['title' => 'Ajouter une tranche'];
        return view('admin/imc/create', $data);
    }

    // Traite l'insertion en BDD
    public function store()
    {
        $model = new IMCModel();
        
        $data = [
            'min'     => $this->request->getPost('min'),
            'max'     => $this->request->getPost('max'),
            'libelle' => $this->request->getPost('libelle'),
        ];

        if ($model->save($data)) {
            return redirect()->to('/admin/imc')->with('success', 'Nouvelle tranche IMC ajoutée avec succès.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de l\'enregistrement.');
        }
    }

    // Affiche le formulaire d'édition
    public function edit($id)
    {
        $model = new IMCModel();
        $categorie = $model->find($id);

        if (!$categorie) {
            return redirect()->to('/admin/imc')->with('error', 'Tranche introuvable.');
        }

        $data = [
            'categorie' => $categorie,
            'title'     => 'Modifier la tranche'
        ];
        
        return view('admin/imc/edit', $data);
    }

    // Traite la mise à jour
    public function update($id)
    {
        $model = new IMCModel();
        
        $data = [
            'min'     => $this->request->getPost('min'),
            'max'     => $this->request->getPost('max'),
            'libelle' => $this->request->getPost('libelle'),
        ];

        if ($model->update($id, $data)) {
            return redirect()->to('/admin/imc')->with('success', 'La tranche a été mise à jour.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la mise à jour.');
        }
    }

    // Supprime une tranche
    public function delete($id)
    {
        $model = new IMCModel();
        if ($model->delete($id)) {
            return redirect()->to('/admin/imc')->with('success', 'Tranche supprimée.');
        } else {
            return redirect()->to('/admin/imc')->with('error', 'Impossible de supprimer cette tranche.');
        }
    }
}