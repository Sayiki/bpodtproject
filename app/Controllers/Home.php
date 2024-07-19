<?php

namespace App\Controllers;

use App\Models\WisataModel;

class Home extends BaseController
{
    public function index(): string
    {
        $model = new WisataModel();
        $data['wisata'] = $model->findAll();

        return view('landing_page', $data);
    }
}
