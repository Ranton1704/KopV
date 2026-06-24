<?php
namespace App\Services;
use CodeIgniter\HTTP\CURLRequest;
use Config\Services;

    /**
    * @var string
    */
    class PaiementService extends BaseService {
        public function insertPaiement(array $data)
        {
            return $this->sendRequest('POST','paiement/add',$data);
        }
    }
?>