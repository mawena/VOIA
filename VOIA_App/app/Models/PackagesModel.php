<?php

namespace App\Models;

use CodeIgniter\Model;

class PackagesModel extends Model{
    protected $table = "packages";
    protected $primaryKey = "token";
    protected $allowedFields = ["token", "productToken", "designation", "slug", "description", "numberPerson", "timeOut", "price", "logoPath"];
}