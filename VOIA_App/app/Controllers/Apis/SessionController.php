<?php

namespace App\Controllers\Apis;

use Config\Services;
use CodeIgniter\RESTful\ResourceController;

class SessionController extends ResourceController
{

    /**
     * Créer la session d'un utilisateur
     *
     * @param string $token
     * @return void
     */
    public function userConnect(string $token = null)
    {
        if ($token == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "L'identifiant de l'utilisateur est manquant!"
            ]);
        } else {
            if ($this->request->getMethod() == "post") {
                $session = Services::session();
                $currentUser["token"] = $token;
                $currentUser["username"] = $this->request->getPost("username");
                $currentUser["last_name"] = $this->request->getPost("last_name");
                $currentUser["first_name"] = $this->request->getPost("first_name");
                $currentUser["email"] = $this->request->getPost("email");
                $currentUser["matricule"] = $this->request->getPost("matricule");
                $currentUser["type"] = $this->request->getPost("type");
                $session->set("currentUser", $currentUser);
                return $this->respond([
                    "status" => "success"
                ]);
                // $_SESSION["currentUser"] = $this->request->getPost("currentUser");
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Vous devez envoyer un formulaire via 'post'"
                ]);
            }
        }
    }


    /**
     * Créer la session d'un utilisateur
     *
     * @param string $token
     * @return void
     */
    public function superAdminConnect(string $token = null)
    {
        if ($token == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "L'identifiant du superAdmin est manquant!"
            ]);
        } else {
            if ($this->request->getMethod() == "post") {
                $session = Services::session();
                $currentUser["token"] = $token;
                $currentUser["username"] = $this->request->getPost("username");
                $currentUser["last_name"] = $this->request->getPost("last_name");
                $currentUser["first_name"] = $this->request->getPost("first_name");
                $currentUser["email"] = $this->request->getPost("email");
                $session->set("currentSuperAdmin", $currentUser);
                return $this->respond([
                    "status" => "success"
                ]);
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Vous devez envoyer un formulaire via 'post'"
                ]);
            }
        }
    }
}
