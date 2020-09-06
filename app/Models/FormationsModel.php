<?php

namespace App\Models;

use CodeIgniter\Model;

class FormationsModel extends Model
{
    protected $table = 'formations';
    protected $allowedFields = ['name', 'slug', 'duration_month', 'trainers', 'certified'];

    public function getFormation($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }
        return $this->asArray()
            ->where(['slug' => $slug])
            ->first();
    }
}
