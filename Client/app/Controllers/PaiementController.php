<?php

namespace App\Controllers;
use App\Services\VilleService;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PaiementController extends BaseController
{
    protected $VilleService;
    public function __construct()
    {
        $this->VilleService = new VilleService();
    }
    public function index()
    {
        $reponse=$this->VilleService->getAllVilles();
        dd($reponse);
        $voyages=[];
        if($reponse['status'] !== 200) {
            die('Erreur lors de la récupération des villes : ' . $reponse['data']);
            return view('paiement', ['voyages' => []]);
        }
        $voyages = $reponse['data']['data'] ?? [];
        return view('paiement', ['voyages' => $voyages]);
    }
}
