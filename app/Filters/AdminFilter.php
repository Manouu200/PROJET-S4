<?php namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null) {
        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/client/home')->with('error', 'Accès refusé.');
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}