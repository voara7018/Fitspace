<?php

namespace App\Controllers;
use App\Models\RessourcesModel;

class Ressources extends BaseController
{
    public function getRessources()
    {
        $model = new RessourcesModel();
        $ressources = $model->findAll();

        return view('ressources', ['ressources' => $ressources]);
    }
}