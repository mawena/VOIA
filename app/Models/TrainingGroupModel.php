<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingGroupModel extends Model
{
    protected $table = 'training_group';
    protected $allowedFields = ['name', 'slug', 'duration_month', 'certified'];

    public function getTraningGroup($slug = false){
        if ($slug === false){
            return $this->findAll();
        }else{
            return $this->asArray()
                        ->where(['slug' => $slug])
                        ->first();
        }
    }
}