<?php

namespace App\Controllers;

use App\Models\WisataModel;
use App\Models\GalleryModel;

class Home extends BaseController
{
    public function index(): string
    {
        $model = new WisataModel();
        $GalleryModel = new GalleryModel();
        $ipAddress = $this->request->getIPAddress(); // Get the visitor's IP address
        $data['wisata'] = $model->findAll();
        $visitorModel = new \App\Models\VisitorModel();
        $visitorModel->incrementDailyVisits($ipAddress);
        $topGalleryItems = $GalleryModel->getFeaturedGalleries();

        return view('landing_page', [
            'wisata' => $data['wisata'],
            'topGalleryItems' => $topGalleryItems
        ]);
    }

    public function detail($nama_wisata)
    {
        $wisataModel = new \App\Models\WisataModel();
        $data['wisata'] = $wisataModel->where('nama_wisata', urldecode($nama_wisata))->first();
        
        if (empty($data['wisata'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the wisata item: '. $nama_wisata);
        }

        $wisataModel->incrementVisitCount($data['wisata']['wisata_id']);

        return view('wisata_detail', $data);
    }
}
