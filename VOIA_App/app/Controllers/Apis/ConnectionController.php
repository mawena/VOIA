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
            if (!$this->validate(["username" => "required"])) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le nom d'utilisateur est manquant!"
                ]);
            }

            if (!$this->validate(["password" => "required"])) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le mot de passe est manquant!"
                ]);
            }

            $currentUser = $userModel->asArray()->where(["username" => $_POST["username"]])->first();
            if ($currentUser == null) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le nom de l'utilisateur '" . $_POST["username"] . "' n'est pas incrit!"
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
                        "message" => "Le nom d'utilisateur '" . $currentPostSuperAdmin["username"] . "' est incorrect !"
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
