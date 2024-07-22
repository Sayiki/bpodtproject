<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\WisataModel;

class WisataController extends BaseController
{
    public function index()
    {
        return view('tambah_data');
    }

    public function index2()
    {
        return view('tampil_data');
    }
}