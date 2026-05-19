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

    public function showMesReservations()
    {
        $userId = session()->get('id');
        if (!$userId) {
            return redirect()->to('/')->with('error', 'Veuillez vous connecter.');
        }

        $name = session()->get('nom');
        $db = \Config\Database::connect();

        $reservations = $db->table('reservations r')
            ->select('
                r.id,
                r.statut,
                c.date_debut,
                c.date_fin,
                ressources.nom AS ressource_nom,
                ressources.type AS ressource_type
            ')
            ->join('creneaux c', 'c.id = r.creneaux_id')
            ->join('ressources', 'ressources.id = c.ressources_id')
            ->where('r.users_id', $userId)
            ->orderBy('c.date_debut', 'ASC')
            ->get()
            ->getResultArray();

        $pendingCount = 0;
        foreach ($reservations as $r) {
            if ($r['statut'] === 'en_attente') {
                $pendingCount++;
            }
        }

        return view('mes_reservations', [
            'reservations' => $reservations,
            'name' => $name,
            'pendingCount' => $pendingCount
        ]);
    }

    public function annulerReservation($id)
    {
        $userId = session()->get('id');
        if (!$userId) {
            return redirect()->to('/')->with('error', 'Veuillez vous connecter.');
        }

        $resaModel = new ReservationModel();
        $reservation = $resaModel->where('id', $id)->where('users_id', $userId)->first();

        if (!$reservation) {
            return redirect()->back()->with('error', 'Réservation introuvable.');
        }

        if ($reservation['statut'] === 'annulé' || $reservation['statut'] === 'annulee') {
            return redirect()->back()->with('error', 'Cette réservation est déjà annulée.');
        }

        // Update reservation status
        $resaModel->update($id, ['statut' => 'annulé']);

        // Restore place in slot
        $creneauModel = new CreneauxModel();
        $creneauModel->where('id', $reservation['creneaux_id'])
            ->set('places_dispo', 'places_dispo + 1', false)
            ->update();

        return redirect()->back()->with('success', 'Réservation annulée avec succès.');
    }
    
}
