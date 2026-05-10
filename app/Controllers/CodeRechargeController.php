<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CodeRechargeModel;

class CodeRechargeController extends BaseController
{
    public function index()
    {
        $model = new CodeRechargeModel();
        $data['codes'] = $model->orderBy('id', 'DESC')->findAll();
        
        $data['totalValides'] = $model->where('est_utilise', 0)->countAllResults();
        $data['totalUtilises'] = $model->where('est_utilise', 1)->countAllResults();
        
        return view('admin/codes/index', $data);
    }

    public function create()
    {
        return view('admin/codes/create');
    }

    public function store()
    {
        $model = new CodeRechargeModel();
        $montant = $this->request->getPost('montant');

        $id = $model->insert([
            'code'        => 'PENDING', 
            'montant'     => $montant,
            'est_utilise' => 0
        ]);

        if ($id) {
            // 2. Génération du code formaté : CD + Montant + - + ID sur 3 chiffres (ex: CD10-001)
            $formattedId = str_pad($id, 3, '0', STR_PAD_LEFT);
            $generatedCode = "CD" . $montant . "-" . $formattedId;
            $model->update($id, ['code' => $generatedCode]);

            return redirect()->to('/admin/codes')->with('success', "Code $generatedCode généré avec succès !");
        }

        return redirect()->back()->with('error', "Erreur lors de la création.");
    }

    public function delete($id)
    {
        $model = new CodeRechargeModel();
        $code = $model->find($id);

        if ($code && $code['est_utilise'] == 1) {
            return redirect()->back()->with('error', "Impossible de supprimer un code déjà utilisé.");
        }

        $model->delete($id);
        return redirect()->to('/admin/codes')->with('success', "Code supprimé.");
    }
}