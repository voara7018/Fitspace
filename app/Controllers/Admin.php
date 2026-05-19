<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function showAdmin()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé. Vous devez être administrateur.');
        }
        return view('admin');
    }
}