<?php

namespace App\Controllers;
use App\Models\CreneauxModel;
use App\Models\UserModel;
use App\Models\ReservationModel;
use App\Models\RessourcesModel;

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
        $modelReservaton = new ReservationModel;
        $statut = $modelReservaton->where('statut', 'en_attente')->countAllResults();
        $statut2 = $modelReservaton->where('statut', 'confirmé')->countAllResults();
        $clients = $modelUser->where('role', 'client')->countAllResults();
       $vraistatut = $modelReservaton
        ->select('users.nom, ressources.nom as nom_ressource, creneaux.date_debut, reservations.statut')
        ->join('users', 'reservations.users_id = users.id')
        ->join('creneaux', 'reservations.creneaux_id = creneaux.id')
        ->join('ressources', 'creneaux.ressources_id = ressources.id')
        ->findAll();


        return view('admin', ['creneaux' => $creneaux, 'clients' => $clients, 'statut' => $statut, 'statut2' => $statut2 , 'vraistatut' => $vraistatut ]);
    }


    public function showAjouterCreneau()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Accès refusé. Vous devez être administrateur.');
        }

        $ressourcesModel = new RessourcesModel();
        $ressources = $ressourcesModel->findAll();

        $creneauxModel = new CreneauxModel();
        $creneaux = $creneauxModel->select('creneaux.*, ressources.nom as ressource_nom, ressources.type as ressource_type, ressources.capacite as ressource_capacite')
            ->join('ressources', 'creneaux.ressources_id = ressources.id')
            ->orderBy('creneaux.date_debut', 'DESC')
            ->findAll();

        return view('admin/ajouter_creneau', [
            'ressources' => $ressources,
            'creneaux' => $creneaux
        ]);
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

        return redirect()->to('/admin/ajouter-creneau')->with('success', 'Créneau ajouté avec succès.');

    }
}