<?php

namespace App\Models;

use CodeIgniter\Model;

class SubscribedPackagesModel extends Model
{
    protected $table = "subscribedPackages";
    protected $primaryKey = "token";
    protected $allowedFields = ["token", "userToken", "packageToken", "subscriptionDate"];
}