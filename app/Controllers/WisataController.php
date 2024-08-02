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
        $perPage = 10; // Number of items per page

        $data['wisata'] = $model->paginate($perPage);
        $data['pager'] = $model->pager;

        return view('tampil_data', $data);
    }

    public function delete_multiple()
    {
        $model = new WisataModel();
        $ids = $this->request->getPost('delete');

        if (!empty($ids)) {
            foreach ($ids as $id) {
                $item = $model->find($id);
                if ($item) {
                    // Delete associated files if they exist
                    if (!empty($item['image']) && file_exists(FCPATH . 'uploads/' . $item['image'])) {
                        unlink(FCPATH . 'uploads/' . $item['image']);
                    }
                    if (!empty($item['peta']) && file_exists(FCPATH . 'uploads/' . $item['peta'])) {
                        unlink(FCPATH . 'uploads/' . $item['peta']);
                    }
                    $model->delete($id);
                }
            }
            session()->setFlashdata('success', 'Selected items deleted successfully.');
        } else {
            session()->setFlashdata('error', 'No items selected for deletion.');
        }

        return redirect()->to('tampil_data');
    }

    public function tambahData()
    {
        $model = new WisataModel();

        // Validate form input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_wisata' => 'required',
            'deskripsi_wisata' => 'required',
            'detail_url' => 'required',
            'peta_wisata' => 'uploaded[peta_wisata]|max_size[peta_wisata,1024]|is_image[peta_wisata]',
            'gambar_wisata' => 'uploaded[gambar_wisata]|max_size[gambar_wisata,1024]|is_image[gambar_wisata]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            session()->setFlashdata('error', $validation->getErrors());
            return redirect()->to('form_data')->withInput();
        }

        // Handle gambar_wisata file upload
        $image = $this->request->getFile('gambar_wisata');
        if ($image->isValid() && !$image->hasMoved()) {
            $newImageName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads', $newImageName);
            $imagePath = 'uploads/' . $newImageName;
        } else {
            session()->setFlashdata('error', 'There was an error uploading the peta_wisata file.');
            return redirect()->to('form_data')->withInput();
        }

        // Handle peta_wisata file upload
        $peta = $this->request->getFile('peta_wisata');
        if ($peta->isValid() && !$peta->hasMoved()) {
            $newPetaName = $peta->getRandomName();
            $peta->move(ROOTPATH . 'public/uploads', $newPetaName);
            $petaPath = 'uploads/' . $newPetaName;
        } else {
            session()->setFlashdata('error', 'There was an error uploading the peta_wisata file.');
            return redirect()->to('form_data')->withInput();
        }

        // Save data to database
        $data = [
            'nama_wisata' => $this->request->getPost('nama_wisata'),
            'deskripsi' => $this->request->getPost('deskripsi_wisata'),
            'detail_url' => $this->request->getPost('detail_url'),
            'image' => $imagePath,
            'peta' => $petaPath
        ];

        if ($model->insert($data)) {
            session()->setFlashdata('success', 'Data wisata berhasil ditambahkan.');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan data wisata.');
        }

        return redirect()->to('form_data');
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
            $image->move(FCPATH . 'public/uploads', $newName);
            $imagePath = 'uploads/' . $newName;
            $data['image'] = $imagePath;
        }

        // Handle peta upload
        $peta = $this->request->getFile('peta');
        if ($peta->isValid() && !$peta->hasMoved()) {
            // Delete old peta if exists
            if ($existingData['peta'] && file_exists(FCPATH . 'uploads/' . $existingData['peta'])) {
                unlink(FCPATH . 'uploads/' . $existingData['peta']);
            }
            $newName = $peta->getRandomName();
            $peta->move(FCPATH . 'public/uploads', $newName);
            $petaPath = 'uploads/' . $newName;
            $data['peta'] = $petaPath;
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
        $item = $model->find($id);

        if (!$item) {
            return $this->response->setJSON(['success' => false, 'message' => 'Item not found']);
        }

        try {
            if ($model->delete($id)) {
                // Delete associated files if they exist
                if (!empty($item['image']) && file_exists(FCPATH . 'uploads/' . $item['image'])) {
                    unlink(FCPATH . 'uploads/' . $item['image']);
                }
                if (!empty($item['peta']) && file_exists(FCPATH . 'uploads/' . $item['peta'])) {
                    unlink(FCPATH . 'uploads/' . $item['peta']);
                }
                return $this->response->setJSON(['success' => true, 'message' => 'Item deleted successfully']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete item']);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error deleting item: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'An error occurred while deleting the item']);
        }
    }

    public function detail($nama_wisata)
    {
        $wisataModel = new \App\Models\WisataModel();
        $data['wisata'] = $wisataModel->where('nama_wisata', urldecode($nama_wisata))->first();

        if (empty($data['wisata'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the wisata item: ' . $nama_wisata);
        }

        // Increment visit count
        $ipAddress = $this->request->getIPAddress();
        $wisataModel->incrementVisitCount($data['wisata']['wisata_id'], $ipAddress);

        return view('wisata_detail', $data);
    }


}