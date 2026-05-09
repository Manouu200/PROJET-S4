<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ActiviteSportiveModel;

class ActiviteSportiveController extends BaseController
{
    public function index()
    {
        $model = new ActiviteSportiveModel();
        $data['activites'] = $model->findAll();
        return view('admin/sports/index', $data);
    }

    public function create()
    {
        return view('admin/sports/create');
    }

    public function store()
    {
        $model = new ActiviteSportiveModel();
        
        $data = [
            'nom'             => $this->request->getPost('nom'),
            'poids_variation' => $this->request->getPost('poids_variation')
        ];

        if ($model->insert($data)) {
            return redirect()->to('/admin/sports')->with('success', 'Activité ajoutée avec succès.');
        } else {
            return redirect()->back()->withInput()->with('error', implode(' ', $model->errors()));
        }
    }

    public function edit($id)
    {
        $model = new ActiviteSportiveModel();
        $data['activite'] = $model->find($id);
        
        if (!$data['activite']) return redirect()->to('/admin/activites');
        
        return view('admin/sports/edit', $data);
    }

    public function update($id)
    {
        $model = new ActiviteSportiveModel();
        
        $data = [
            'nom'             => $this->request->getPost('nom'),
            'poids_variation' => $this->request->getPost('poids_variation')
        ];

        if ($model->update($id, $data)) {
            return redirect()->to('/admin/sports')->with('success', 'Activité mise à jour.');
        } else {
            return redirect()->back()->withInput()->with('error', implode(' ', $model->errors()));
        }
    }

    public function delete($id)
    {
        $model = new ActiviteSportiveModel();
        $model->delete($id);
        return redirect()->to('/admin/sports')->with('success', 'Activité supprimée.');
    }
}