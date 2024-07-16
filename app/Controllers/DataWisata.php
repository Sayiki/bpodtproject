<?php

namespace App\Controllers;

use App\Models\DataWisataModel;

class DataWisata extends BaseController
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
