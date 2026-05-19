<?php

namespace App\Controllers;
use App\Models\CreneauxModel;


class Admin extends BaseController
{
    public function showAdmin()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé. Vous devez être administrateur.');
        }

        $model = new CreneauxModel;
        $creneaux = $model->findAll();
        return view('admin/admin', ['creneaux' => $creneaux]);
    }
}