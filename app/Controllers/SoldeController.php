<?php 

namespace App\Controllers;

use App\Services\SoldeService;

class SoldeController extends BaseController
{
	public function rechargerSolde()
	{
		$userId = session()->get('user_id');
		if (!$userId) {
			if ($this->request->isAJAX()) {
				return $this->response
					->setStatusCode(401)
					->setJSON(['success' => false, 'message' => 'Non authentifie']);
			}

			return redirect()->to('/login');
		}

		$codeRecharge = (string) $this->request->getPost('code_recharge');
		$service = new SoldeService();
		$result = $service->rechargerSolde($codeRecharge, (int) $userId);

		if (! $result['success']) {
			if ($this->request->isAJAX()) {
				return $this->response
					->setStatusCode(400)
					->setJSON(['success' => false, 'message' => $result['message']]);
			}

			return redirect()->back()->with('error', $result['message']);
		}

		if ($this->request->isAJAX()) {
			return $this->response->setJSON([
				'success' => true,
				'message' => 'Solde recharge avec succes.',
				'solde' => $service->getSoldeUtilisateur((int) $userId),
			]);
		}

		return redirect()->back()->with('success', 'Solde recharge avec succes.');
	}
}

?>