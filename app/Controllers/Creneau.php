<?php

namespace App\Controllers;
use App\Models\CreneauxModel;

class Creneau extends BaseController
{
    public function showCreneaux()
    {
        return view('creneaux');
    }
    
    public function showCreneauDispo()
    {
        return $this->getCreneauDispo();
    }

    public function getCreneauDispo()
    {
        $creneauModel = new CreneauxModel();

        $creneaux = $creneauModel->select('creneaux.*,
            ressources.nom as ressource_nom,
            ressources.type as ressource_type,
            ressources.capacite as ressource_capacite,
            ressources.description as ressource_description')
            
        ->join('ressources', 'creneaux.ressources_id = ressources.id')
        ->where('creneaux.actif', 1)
        ->findAll();

        $data = [
            'creneaux' => $creneaux,
            'total'    => count($creneaux),
        ];

        return view('creneaux_dispo', $data);
    }


}