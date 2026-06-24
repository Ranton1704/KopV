<?php

namespace App\Controllers;

class ReservationController extends BaseController
{
    public function catalogue()
    {
        // 1. Vérifier si l'utilisateur est connecté (simple check)
        // $session = service('session');
        // if (! $session->get('isLoggedIn')) {
        //     return redirect()->to('/login')->getBody();
        // }

        // 2. Récupérer les filtres depuis POST
        $post = $this->request->getPost();
        $filtres = [
            'date_debut'    => $post['date_debut'] ?? null,
            'date_fin'      => $post['date_fin'] ?? null,
            'tri'           => $post['tri'] ?? 'DESC',
            'numero_page'   => isset($post['numero_page']) ? (int) $post['numero_page'] : 1,
            'nombre_lignes' => isset($post['nombre_lignes']) ? (int) $post['nombre_lignes'] : 10,
        ];

        // 3. Appel au service
        $service = new \App\Services\ReservationService();
        $result = $service->getVoyagesPrevus($filtres);

        $voyages = $result['voyages'] ?? [];
        $meta = $result['meta'] ?? null;

        // 4. Retourne la vue avec les données
        return view('catalogue-voyages', [
            'voyages' => $voyages,
            'meta'    => $meta,
            'filtres' => $filtres,
        ]);
    }

    public function liste()
    {
        return view('liste-reservations');
    }
}