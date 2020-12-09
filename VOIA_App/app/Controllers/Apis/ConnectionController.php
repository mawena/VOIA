<?php

namespace App\Controllers\Apis;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class ConnectionController extends ResourceController
{
    public function userConnection()
    {
        $userModel = new UserModel();
        if ($this->request->getMethod() == "post") {
            if ($this->validate(["email" => "required"])) {
                if (!$this->validate(["email" => "valid_email"])) {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "L'email est invalide"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "L'email est manquant"
                ]);
            }

            if (!$this->validate(["password" => "required"])) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le mot de passe est manquant!"
                ]);
            }

            $currentPostUser["email"] = $this->request->getPost("email");
            $currentUser = $userModel->asArray()->where(["email" => $currentPostUser["email"]])->first();

            if ($currentUser == null) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "l'email " . $currentPostUser["email"] . " n'est pas incrit!"
                ]);
            } else {
                if (password_verify($this->request->getPost("password"), $currentUser["password"])) {
                    return $this->respond([
                        "status" => "success",
                        "data" => $currentUser
                    ]);
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le mot de passe est incorrect!"
                    ]);
                }
            }
        } else {
            return $this->respond([
                "status" => "failed",
                "message" => "Vous devez utiliser la méthode 'post'"
            ]);
        }
    }
}
