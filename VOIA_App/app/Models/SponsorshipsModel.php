<?php

namespace App\Models;

use CodeIgniter\Model;

class SponsorshipsModel extends Model
{
    protected $table = "sponsorships";
    protected $primaryKey = "token";
    protected $allowedFields = ["token", "godFatherToken", "godDauhterToken"];
}