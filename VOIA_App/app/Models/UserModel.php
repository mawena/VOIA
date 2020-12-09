<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = "token";
    protected $allowedFields = ['token', 'username', 'password', 'type', 'last_name', 'first_name', 'email', 'sex', 'matricule'];

    /**
     * Retourne l'id du dernier utilisateur enregistré!
     *
     * @return void
     */
    public function getLastedId()
    {
        $id = 0;
        foreach ($this->findAll() as $user) {
            if ($id < $user["id"]) {
                $id = $user["id"];
            }
        }
        return $id;
    }
}
