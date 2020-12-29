<?php

namespace App\Models;

use CodeIgniter\Model;

class UserWaitingModel extends Model
{
    protected $table = 'usersWaiting';
    protected $primaryKey = "token";
    protected $allowedFields = ['token', 'username', 'password', 'codeParainnage', 'type', 'last_name', 'first_name', 'email', 'slugPackage', 'phoneNumber', 'whatsappNumber', 'country', 'sex', 'matricule', 'admissionDate'];

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
