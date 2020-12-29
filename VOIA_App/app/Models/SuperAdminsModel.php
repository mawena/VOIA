<?php

namespace App\Models;

use CodeIgniter\Model;

class SuperAdminsModel extends Model
{
    protected $table = "superAdmins";
    protected $primaryKey = "token";
    protected $allowedFields = ["token", "username", "password", "lastName", "firstName", "email", "sex", "creationDate"];
}