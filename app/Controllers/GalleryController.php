<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\GalleryModel;

class GalleryController extends ResourceController
{
    protected $modelName = 'App\Models\GalleryModel';
    protected $format = 'json';

    public function index()
    {
        $data = $this->model->findAll();
        return view('gallery', ['data' => $data]);
    }

    public function create()
    {
        $validationRule = [
            'title' => 'required|min_length[3]|max_length[255]',
            'image' => [
                'uploaded[image]',
                'mime_in[image,image/jpg,image/jpeg,image/gif,image/png]',
                'max_size[image,4096]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            return $this->response->setJSON(['error' => $this->validator->getErrors()]);
        }

        $image = $this->request->getFile('image');

        if ($image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            if ($image->move(ROOTPATH . 'public/uploads', $newName)) {
                $imagePath = 'uploads/' . $newName;

                $data = [
                    'title' => $this->request->getPost('title'),
                    'image' => $imagePath
                ];

                if ($this->model->insert($data)) {
                    return $this->response->setJSON(['success' => true, 'message' => 'Gallery item added successfully']);
                } else {
                    return $this->response->setJSON(['error' => 'Failed to insert data into database']);
                }
            } else {
                return $this->response->setJSON(['error' => 'Failed to move uploaded file']);
            }
        } else {
            return $this->response->setJSON(['error' => 'Invalid file or file has already been moved']);
        }
    }

    public function update($id = null)
    {
        $model = new GalleryModel();

        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'error' => $this->validator->getErrors()]);
        }

        $updateData = [
            'title' => $this->request->getPost('title'),
        ];

        // Handle image update if a new image is uploaded
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            if ($image->move(ROOTPATH . 'public/uploads', $newName)) {
                $updateData['image'] = 'uploads/' . $newName;

                // Delete old image
                $oldData = $model->find($id);
                if ($oldData && file_exists(ROOTPATH . 'public/' . $oldData['image'])) {
                    unlink(ROOTPATH . 'public/' . $oldData['image']);
                }
            }
        }

        if ($model->update($id, $updateData)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Item updated successfully']);
        } else {
            return $this->response->setJSON(['success' => false, 'error' => 'Failed to update item']);
        }
    }

    public function edit($id = null)
    {
        $model = new GalleryModel();
        $data = $model->find($id);

        if ($data) {
            return $this->response->setJSON(['success' => true, 'data' => $data]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Item not found']);
        }
    }


    public function saveOrder()
    {
        $model = new GalleryModel();
        $data = $this->request->getJSON();

        foreach ($data as $index => $item) {
            $model->update($item->id, ['order' => $index]);
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Order saved successfully']);
    }

    public function delete($id = null)
    {
        $model = new GalleryModel();
        $gallery = $model->find($id);

        if ($gallery) {
            // Delete the image file
            $imagePath = ROOTPATH . 'public/' . $gallery['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Delete the database record
            if ($model->delete($id)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Gallery item deleted successfully']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete gallery item']);
            }
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gallery item not found']);
        }
    }
}