<?php

namespace App\Controllers;

use App\Models\ClientModel;
use CodeIgniter\Controller;

class ClientsController extends SecureBaseController
{

public function __construct()
    {
         parent::__construct(); // 🔹 Vérifie la session utilisateur
     }
    public function search($telephone)
    {
        $model = new ClientModel();

        $client = $model->where('telephone', $telephone)->first();

        if($client){
            return $this->response->setJSON([
                'status' => 'found',
                'nom' => $client['nom'],
                'id' => $client['id']
            ]);
        }else{
            return $this->response->setJSON([
                'status' => 'not_found'
            ]);
        }

    }
    public function storeAjax()
{
    $model = new \App\Models\ClientModel();

    $data = [

        'nom' => $this->request->getPost('nom'),

        'telephone' => $this->request->getPost('telephone')

    ];

    $id = $model->insert($data);

    return $this->response->setJSON([
        'status' => 'ok',
        'id' => $id
    ]);
}

}