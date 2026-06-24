<?php

namespace App\Services;

class ReservationService extends BaseService
{
    /**
     * Récupère les voyages prévus depuis l'API spring-boot en appliquant des filtres.
     * Retourne un tableau de voyages (vide en cas d'erreur).
     *
     * @param array $filtres
     * @return array
     */
    public function getVoyagesPrevus(array $filtres = []): array
    {
        $dateDebut = !empty($filtres['date_debut']) ? $filtres['date_debut'] : null;
        $dateFin   = !empty($filtres['date_fin']) ? $filtres['date_fin'] : null;

        if ($dateDebut !== null && $dateFin === null) {
            $dateFin = $dateDebut;
        } elseif ($dateFin !== null && $dateDebut === null) {
            $dateDebut = $dateFin;
        }

        $parametresQuery = [
            'date_debut'    => $dateDebut,
            'date_fin'      => $dateFin,
            'tri'           => $filtres['tri'] ?? 'DESC',
        ];

        // Nettoyage des valeurs nulles ou vides
        $parametresQuery = array_filter($parametresQuery, function ($valeur) {
            return $valeur !== '' && $valeur !== null;
        });

        // Envoie des données au backend via BaseService::sendRequest
        $result = $this->sendRequest('GET', 'voyages/prevus', $parametresQuery);

        if (isset($result['status']) && $result['status'] >= 200 && $result['status'] < 300) {
            // Backend renvoie { data: [...], meta: { total, page, size } }
            $body = $result['data'];
            $voyages = $body['data'] ?? ($body ?: []);
            $meta = $body['meta'] ?? null;

            return [
                'voyages' => is_array($voyages) ? $voyages : [],
                'meta'    => $meta,
            ];
        }

        return [
            'voyages' => [],
            'meta'    => null,
        ];
    }
}
