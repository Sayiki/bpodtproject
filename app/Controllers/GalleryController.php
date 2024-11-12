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
        $model = new GalleryModel();

        // Set the number of items per page
        $perPage = 4;

        // Get the current page from the URL, default to 1 if not set
        $page = $this->request->getVar('page') ?? 1;

        // Get the total count of gallery items
        $totalItems = $model->countAllResults();

        // Get paginated data
        $data = $model->paginate($perPage, 'default', $page);

        // Create the pager object
        $pager = $model->pager;

        $topGalleryItems = $model->getTopThree();

        return view('gallery', [
            'data' => $data,
            'pager' => $pager,
            'totalItems' => $totalItems,
            'topGalleryItems' => $topGalleryItems
        ]);
    }

    public function setHome()
    {
        $model = new GalleryModel();
        $ids = $this->request->getJSON()->ids;

        if (count($ids) > 3 || count($ids) < 1) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You must select between 1 and 3 items for the home gallery.'
            ]);
        }

        try {
            $model->resetHomeGallery();
            foreach ($ids as $id) {
                $model->setHomeGallery($id);
            }
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Home gallery items set successfully'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error setting home gallery: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to set home gallery items'
            ]);
        }
    }
    public function setFeatured()
    {
        $model = new GalleryModel();
        $id = $this->request->getPost('id');
        $isFeatured = $this->request->getPost('is_featured');

        // Check if we already have 3 featured images
        $featuredCount = $model->where('is_featured', 1)->countAllResults();

        if ($isFeatured && $featuredCount >= 3) {
            return $this->response->setJSON(['success' => false, 'message' => 'Maximum of 3 featured images allowed']);
        }

        if ($model->update($id, ['is_featured' => $isFeatured])) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update featured status']);
        }
    }

    public function manageFeatured()
    {
        $model = new GalleryModel();
        $data['galleries'] = $model->findAll();
        return view('gallery_manage_featured', $data);
    }

    public function updateFeatured()
    {
        $model = new GalleryModel();
        $featuredIds = $this->request->getPost('featured');

        // Start a transaction
        $model->db->transStart();

        // Reset all to not featured
        $model->where('1=1')->update(null, ['is_featured' => 0]);

        // Update selected as featured
        if (is_array($featuredIds) && count($featuredIds) <= 3) {
            foreach ($featuredIds as $id) {
                $model->update($id, ['is_featured' => 1]);
            }
            $model->db->transComplete();
            return redirect()->to('gallery/manage-featured')->with('success', 'Featured galleries updated successfully');
        } else {
            $model->db->transRollback();
            return redirect()->to('gallery/manage-featured')->with('error', 'Please select up to 3 galleries');
        }
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
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
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
                    return redirect()->to('gallery')->with('success', 'Gallery item added successfully');
                } else {
                    return redirect()->back()->withInput()->with('error', 'Failed to insert data into database');
                }
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to move uploaded file');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Invalid file or file has already been moved');
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

    public function add()
    {
        return view('gallery_add');
    }
}