<?php

namespace App\Models\admins;

use CodeIgniter\Model;


class AdminModel extends Model
{
    const UNDEFINED_USER = 2;
    const BAD_PASSWORD = 3;
    protected $table = 'admins';

    public function getAdmin($identifiant = false, $password = false)
    {
        $adminData = $this->asArray()->where(['user_name' => $identifiant])->first();
        if ($adminData !== NULL) {
            return \password_verify($password, $adminData['password']) ? $adminData : self::BAD_PASSWORD;
        } else {
            return self::UNDEFINED_USER;
        }
    }

    public function getAllAdmin()
    {
        return $this->findAll();
    }
}
