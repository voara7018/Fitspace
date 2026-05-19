<?php

namespace App\Controllers;

class Creneau extends BaseController
{
    public function showCreneaux()
    {
        return view('creneaux');
    }
    
    public function showCreneauDispo()
    {
        return view('creneaux_dispo');
    }
}