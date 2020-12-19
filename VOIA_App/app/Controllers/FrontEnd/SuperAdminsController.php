<?php

namespace App\Controllers\FrontEnd;

use Config\Services;
use App\Libraries\Helper;
use CodeIgniter\Controller;

class SuperAdminsController extends Controller
{
    public function superAdminConnexion()
    {
        $data["title"] = "Connexion - admin";
        echo view("templates/header", $data);
        echo view("templates/nav", $data);
        echo view("pages/connexionViewAdmin", $data);
        echo view("templates/footer", $data);
    }

    public function superAdminDashboard()
    {
        $session = Services::session();
        if (isset($_SESSION['currentSuperAdmin'])) {
            $data = [
                "title" => "Tableau de bord - admin",
            ];

            $response = json_decode(file_get_contents(Helper::getBaseUrl() . "/apis/userswaiting"));
            if (isset($response->status) && $response->status == "failed") {
                $data["userWaitingArray"] = [];
            } else {
                foreach ($response as $key => $userWaitingArray) {
                    $data["usersWaitingArray"][$key] = get_object_vars($userWaitingArray);
                }
            }

            if (isset($data["usersWaitingArray"]["status"]) && $data["usersWaitingArray"]["status"] == "failed") {
                $data["usersWaitingArray"] = [];
            }

            echo view("templates/header", $data);
            echo view("templates/nav", $data);
            echo view("pages/dashboardAdmin", $data);
            echo view("templates/footer", $data);
        } else {
            return redirect()->to("/admin/connexion");
        }
    }
}
