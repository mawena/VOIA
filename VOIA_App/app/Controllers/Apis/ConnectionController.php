<?php

namespace App\Controllers\Apis;

use App\Models\UserModel;
use App\Models\SuperAdminsModel;
use CodeIgniter\RESTful\ResourceController;

class ConnectionController extends ResourceController
{
    /**
     * Connecte un utilisateur
     *
     * @return void
     */
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

    /**
     * Connecte un superUtilisateur
     *
     * @return void
     */
    public function superAdminConnection()
    {
        $superAdminModel = new SuperAdminsModel();
        if ($this->request->getMethod() == "post") {
            if ($this->validate(["username" => "required"])) {
                $currentPostSuperAdmin["username"] = $this->request->getPost("username");
                $currentSuperAdmin = $superAdminModel->where(["username" => $currentPostSuperAdmin["username"]])->first();
                if ($currentSuperAdmin == [] or $currentPostSuperAdmin == null) {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le nom d'utilisateur '" . $currentPostSuperAdmin["username"] . "' n'est pas inscrit!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le nom d'utilisateur est manquant!"
                ]);
            }

            if ($this->validate(["password" => "required"])) {
                if (password_verify($this->request->getPost("password"), $currentSuperAdmin["password"])) {
                    return $this->respond([
                        "status" => "success",
                        "data" => $currentSuperAdmin
                    ]);
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le mot de passe est incorrect!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le mot de passe est manquant!"
                ]);
            }
        } else {
            return $this->respond([
                "status" => "failed",
                "message" => "Vous devez utiliser la méthode 'post'"
            ]);
        }
    }
}
