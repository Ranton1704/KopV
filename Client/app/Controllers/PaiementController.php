<?php

namespace App\Controllers;
use App\Services\VilleService;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Services\PaiementService;

class PaiementController extends BaseController
{
    protected $VilleService;
    protected $PaiementService;
    public function __construct()
    {
        $this->VilleService = new VilleService();
        $this->PaiementService = new PaiementService();
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
   public function insertPaiement(){
        $modePaiement = $this->request->getPost('mode_paiement');
        $numeroCarte = $this->request->getPost('numero_carte');
       $request=$this->PaiementService->insertPaiement([
            'mode_paiement' => $modePaiement,
            'numero_carte' => $numeroCarte
        ]);
        // var_dump($request);
        if($request['status'] !== 200) {

            die('Erreur lors de l\'insertion du paiement : ' . $request['data']);
        }
        return redirect()->to('/paiement');
   }
}
