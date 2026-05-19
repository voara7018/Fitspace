<?php

namespace App\Controllers;
use App\Models\CreneauxModel;
use App\Models\UserModel;


class Admin extends BaseController
{
    public function showAdmin()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé. Vous devez être administrateur.');
        }

        $model = new CreneauxModel;
        $creneaux = $model->findAll();
        $modelUser = new UserModel;
        $clients = $modelUser->where('role', 'client')->countAllResults();


        return view('admin/admin', ['creneaux' => $creneaux, 'clients' => $clients]);
    }

    public function showAjouterCreneau()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé. Vous devez être administrateur.');
        }

        return view('admin/ajouter_creneau');
    }

    public function ajouterCreneau()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé. Vous devez être administrateur.');
        }

        $model = new CreneauxModel;

        $data = [
            'ressources_id' => $this->request->getPost('ressources_id'),
            'date_debut' => $this->request->getPost('date_debut'),
            'date_fin' => $this->request->getPost('date_fin'),
            'places_dispo' => $this->request->getPost('places_dispo'),
            'actif' => 1
        ];

        $model->insert($data);

        return redirect()->to('/')->with('success', 'Créneau ajouté avec succès.');

    }
}