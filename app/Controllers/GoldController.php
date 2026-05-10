<?php

namespace App\Controllers;
use App\Services\GoldService;

class GoldController extends BaseController 
{
    public function payer()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403);
        }

        $userId = session()->get('user_id');
        $goldService = new GoldService();
        $result = $goldService->payerAbonnementGold($userId);
        return $this->response->setJSON($result);
    }
}