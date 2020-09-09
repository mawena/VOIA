<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{

    const UNDEFINED_USER = 2;
    const BAD_PASSWORD = 3;

    protected $table = 'users';
    protected $allowedFields = ['identifiant', 'password', 'last_name', 'first_name', 'email', 'sex', 'nb_parain'];
    
    public function getUser($identifiant = false, $password = false){
        $userData = $this->asArray()->where(['identifiant' => $identifiant ])->first();
        if($userData !== NULL){
            return \password_verify($password, $userData['password']) ? $userData : self::BAD_PASSWORD;
        }else{
            return self::UNDEFINED_USER;
        }
    }

    public function getAllUsers(){
        return $this->findAll();
    }

    
}