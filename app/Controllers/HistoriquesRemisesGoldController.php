<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HistoriqueRemisesGoldModel;

class HistoriquesRemisesGoldController extends BaseController
{
    public function index()
    {
        $model = new HistoriqueRemisesGoldModel();
        $data['remises'] = $model->orderBy('created_at', 'DESC')->findAll();
        return view('admin/remises/index', $data);
    }

    public function create()
    {
        return view('admin/remises/create');
    }

    public function store()
    {
        $model = new HistoriqueRemisesGoldModel();
        $data = [
            'pourcent_remise' => $this->request->getPost('pourcent_remise'),
            'created_at'      => date('Y-m-d H:i:s')
        ];

        if ($model->insert($data)) {
            return redirect()->to('/admin/remises')->with('success', 'La remise a été mise à jour.');
        }
        return redirect()->back()->with('error', 'Erreur lors de la mise à jour.');
    }

    public function delete($id)
    {
        (new HistoriqueRemisesGoldModel())->delete($id);
        return redirect()->to('/admin/remises')->with('success', 'Entrée supprimée de l\'historique.');
    }
}