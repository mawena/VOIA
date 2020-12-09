<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingsModel extends Model
{
    protected $table = 'trainings_groups';
    protected $allowedFields = ['name', 'slug', 'duration_month', 'certified'];

    public function getTraning($slug = false)
    {
        return $this->asArray()
            ->where(['slug' => $slug])
            ->first();
    }

    public function getAllTraning()
    {
        return $this->findAll();
    }
}
