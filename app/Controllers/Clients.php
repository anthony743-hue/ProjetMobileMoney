<?php

namespace App\Controllers;

use App\Models\ClientModel;

class Clients extends BaseController
{
    public function situation()
    {
        $clientModel = new ClientModel();

        $clients = $clientModel->getAllClients();
        $totaux  = $clientModel->getTotaux();

        return view('clients/situation', [
            'clients' => $clients,
            'totaux'  => $totaux,
        ]);
    }
}