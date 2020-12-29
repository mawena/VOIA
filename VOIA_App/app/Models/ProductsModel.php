<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductsModel extends Model
{
    protected $table = "products";
    protected $primaryKey = "token";
    protected $allowedFields = ["token", "designation", "description", "price", "logoPath"];
}