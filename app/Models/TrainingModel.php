<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingModel extends Model
{
    protected $table = 'training';
    protected $allowedFields = ['name', 'slug', 'duration_month', 'trainers', 'certified'];

    public function getTraining($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }
        return $this->asArray()
            ->where(['slug' => $slug])
            ->first();
    }

    public function getTrainingByTrainingGroupSlug($slug = null)
    {
        return $this->asArray()
            ->retgex()
            ->first();
    }
}
