<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\WisataModel;

class WisataController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        return view('form_data');
    }

    public function index2()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        $model = new WisataModel();
        $data['wisata'] = $model->findAll();

        return view('tampil_data', $data);
    }

    public function tambahData()
    {
        $model = new WisataModel();

        // Validate form input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_wisata' => 'required',
            'deskripsi_wisata' => 'required',
            'gambar_wisata' => 'uploaded[gambar_wisata]|max_size[gambar_wisata,1024]|is_image[gambar_wisata]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }

        // Handle file upload
        $img = $this->request->getFile('gambar_wisata');
        if ($img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move(ROOTPATH . 'public/uploads', $newName);
        } else {
            return $this->response->setJSON(['success' => false, 'error' => 'There was an error uploading the file.']);
        }

        // Save data to database
        $data = [
            'nama_wisata' => $this->request->getPost('nama_wisata'),
            'deskripsi' => $this->request->getPost('deskripsi_wisata'),
            'detail_url' => '', // You can add this later if needed
            'peta' => 'uploads/' . $newName // Save the file path
        ];

        $model->insert($data);

        return $this->response->setJSON(['success' => true, 'message' => 'Data wisata berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        $model = new WisataModel();
        $data = $model->find($id);

        if (empty($data)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data not found']);
        }

        return $this->response->setJSON($data);
    }

    public function update($id)
{
    $model = new WisataModel();
    $existingData = $model->find($id);

    $data = [
        'nama_wisata' => $this->request->getPost('nama_wisata'),
        'deskripsi' => $this->request->getPost('deskripsi'),
        'detail_url' => $this->request->getPost('detail_url'),
    ];

    // Handle image upload
    $image = $this->request->getFile('image');
    if ($image->isValid() && !$image->hasMoved()) {
        // Delete old image if exists
        if ($existingData['image'] && file_exists(FCPATH . 'uploads/' . $existingData['image'])) {
            unlink(FCPATH . 'uploads/' . $existingData['image']);
        }
        $newName = $image->getRandomName();
        $image->move(FCPATH . 'uploads', $newName);
        $data['image'] = $newName;
    }

    // Handle peta upload
    $peta = $this->request->getFile('peta');
    if ($peta->isValid() && !$peta->hasMoved()) {
        // Delete old peta if exists
        if ($existingData['peta'] && file_exists(FCPATH . 'uploads/' . $existingData['peta'])) {
            unlink(FCPATH . 'uploads/' . $existingData['peta']);
        }
        $newName = $peta->getRandomName();
        $peta->move(FCPATH . 'uploads', $newName);
        $data['peta'] = $newName;
    }

    if ($model->update($id, $data)) {
        return $this->response->setJSON(['success' => true, 'message' => 'Data wisata berhasil diperbarui.']);
    } else {
        return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui data wisata.']);
    }
}

    public function delete($id)
    {
        $model = new WisataModel();

        if ($model->delete($id)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false]);
        }
    }


}