<?php

namespace App\Controllers;
use App\Models\ReservationModel;
use App\Models\CreneauxModel;

class Reservation extends BaseController
{
        public function showReserver($creneauId)
        {
            

            $model = new CreneauxModel();
            $creneau = $model->find($creneauId);

            if (!$creneau) {
                return redirect()->to('/creneaux-disponibles')
                    ->with('error', 'Créneau introuvable.');
            }

            if ($creneau['places_dispo'] <= 0) {
                return redirect()->to('/creneaux-disponibles')
                    ->with('error', 'Désolé, ce créneau est complet.');
            }

            $resaModel = new ReservationModel();
            
            $resaModel->insert([
                'users_id'     => session()->get('id'),
                'creneaux_id'  => $creneauId,
                'statut'       => 'en_attente',
                'created_at'   => date('Y-m-d H:i:s')
            ]);
            if ($resaModel) {
                $model->where('id', $creneauId)->set('places_dispo', 'places_dispo - 1', false)->update();
            }

            return redirect()->to('/creneaux-disponibles')
                ->with('success', 'Réservation effectuée avec succès.');
        }
    
}
