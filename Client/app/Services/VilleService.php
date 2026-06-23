<?php
namespace App\Services;


use CodeIgniter\HTTP\CURLRequest;
use Config\Services;

class VilleService extends BaseService {
    /**
    * @var string
    */


    public function getAllVilles():array
    {
        return $this->sendRequest('GET','ville');
    }
    
}


?>