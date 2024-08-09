<?php

namespace App\Models;

use CodeIgniter\Model;

class GalleryModel extends Model
{
    protected $table = 'gallery_data';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'image', 'order'];
}