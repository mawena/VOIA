<?php

namespace App\Models;

use CodeIgniter\Model;

class CoursesModel extends Model
{
    protected $table = 'trainings';
    protected $allowedFields = ['name', 'slug', 'duration_month', 'trainers', 'certified'];

    public function getCourse($slug = false)
    {
        return $this->asArray()
            ->where(['slug' => $slug])
            ->first();
    }

    public function getAllCourses(){
        return $this->findAll();
    }

    public function findBy($column, $value)
    {
        return $this->asArray()
            ->like([$column => $value])
            ->findAll();
    }
}
