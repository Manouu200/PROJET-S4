<?php 

namespace App\Controllers;

use App\Models\PortefeuilleModel;

class SoldeController 
{
    public function showSolde(){
        $userId = session()->get('user_id');
        if (!$userId){
            return redirect()->to('/login');
        }
    }
}

?>