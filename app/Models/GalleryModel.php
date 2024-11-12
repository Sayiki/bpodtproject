<?php

namespace App\Models;

use CodeIgniter\Model;

class GalleryModel extends Model
{
    protected $table = 'gallery_data';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'image', 'order', 'is_home', 'is_featured'];

    public function getTopThree()
    {
        return $this->orderBy('order', 'ASC')
            ->limit(3)
            ->find();
    }

    public function getFeaturedGalleries()
    {
        return $this->where('is_featured', 1)->findAll();
    }


    public function resetHomeGallery()
    {
        return $this->db->table($this->table)->update(['is_home' => 0]);
    }

    public function setHomeGallery($id)
    {
        return $this->db->table($this->table)->where('id', $id)->update(['is_home' => 1]);
    }


}