<?php

namespace App\Controllers\FrontEnd;

use App\Controllers\Apis\UsersController;
use App\Libraries\Helper;
use App\Models\PackagesModel;
use App\Libraries\HTTPRequester;
use App\Models\SponsorshipsModel;
use App\Models\SubscribedPackagesModel;
use App\Models\UserModel;
use App\Models\UserWaitingModel;
use Config\Services;
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
        $userModel = new UserModel();
        $userWaintingModel = new UserWaitingModel();
        $sponsorshipsModel = new SponsorshipsModel();
        $subscribedPackagesModel = new SubscribedPackagesModel();
        $packageModel = new PackagesModel();
        if (isset($_SESSION['currentSuperAdmin'])) {
            $data = [
                "title" => "Tableau de bord - admin",
                "userWaitingArray" => $userWaintingModel->orderBy("admissionDate", "DESC")->findAll(),
                "communicateurUserArray" => [],
            ];

            foreach ($data["userWaitingArray"] as $key => $userWainting) {

                $data["userWaitingArray"][$key]["parrain"] = $userModel->where(["matricule" => $userWainting["codeParainnage"]])->first();
                // $data["userWaitingArray"][$key]["package"] = $packageModel->where(['token' => $subscribedPackagesModel->where(["userToken" => $userWainting["token"]])->first()['packageToken']])->first()['slug'];
            }

            foreach ($userModel->orderBy("admissionDate", "DESC")->where(["type" => "communicateur"])->findAll() as $key => $tmpUser) {
                $data["communicateurUserArray"][$key] = $tmpUser;
                foreach ($subscribedPackagesModel->where(["userToken" => $tmpUser["token"]])->findAll() as $tmpSubscribedPackage) {
                    $data["communicateurUserArray"][$key]["package"][] = $packageModel->find($tmpSubscribedPackage["packageToken"]);
                }
            }

            foreach ($userModel->where(["type" => "normal"])->orderBy("admissionDate", "DESC")->findAll() as $key => $tmpUser) {
                $data["validateUserArray"][$key] = $tmpUser;
                $data["validateUserArray"][$key]["parrain"] = $userModel->find(($sponsorshipsModel->where(["godDauhterToken" => $tmpUser["token"]])->first())["godFatherToken"]);
                $data["validateUserArray"][$key]["package"] = $packageModel->find(($subscribedPackagesModel->where(["userToken" => $tmpUser["token"]])->first())["packageToken"]);
            }

            // var_dump($data["communicateurUserArray"]);

            echo view("templates/header", $data);
            echo view("templates/nav", $data);
            echo view("pages/dashboardAdmin", $data);
            echo view("templates/footer", $data);
        } else {
            return redirect()->to("/admin/connexion");
        }
    }

    public function superAdminDashboardSearch()
    {
        $session = Services::session();
        $userModel = new UserModel();
        $userWaintingModel = new UserWaitingModel();
        $sponsorshipsModel = new SponsorshipsModel();
        $subscribedPackagesModel = new SubscribedPackagesModel();
        $packageModel = new PackagesModel();
        $baseUrl = Helper::getBaseUrl();
        if (isset($_SESSION['currentSuperAdmin'])) {
            $data = [
                "title" => "Tableau de bord - admin",
                "userWaitingArray" => $userWaintingModel->orderBy("admissionDate", "DESC")->findAll(),
                "communicateurUserArray" => [],
                "validateUserArray" => []
            ];

            if ($this->request->getPost("page") == "waiting") {
                $tmpResponse = (json_decode(HTTPRequester::HTTPPost($baseUrl . "/apis/users/search", ["key" => $this->request->getPost("key"), "value" => $this->request->getPost("value"), "userStatus" => "userWaiting"])));
                $data["userWaitingArray"] = [];
                if (!isset($tmpResponse->status)) {
                    foreach ($tmpResponse as $tmp) {
                        $data["userWaitingArray"][] = get_object_vars($tmp);
                    }
                }
            }

            foreach ($data["userWaitingArray"] as $key => $userWainting) {
                $data["userWaitingArray"][$key]["parrain"] = $userModel->where(["matricule" => $userWainting["codeParainnage"]])->first();
            }

            foreach ($userModel->orderBy("admissionDate", "DESC")->where(["type" => "communicateur"])->findAll() as $key => $tmpUser) {
                $data["communicateurUserArray"][$key] = $tmpUser;
                foreach ($subscribedPackagesModel->where(["userToken" => $tmpUser["token"]])->findAll() as $tmpSubscribedPackage) {
                    $data["communicateurUserArray"][$key]["package"][] = $packageModel->find($tmpSubscribedPackage["packageToken"]);
                }
            }

            $tmpValidateUserArray = $userModel->where(["type" => "normal"])->orderBy("admissionDate", "DESC")->findAll();

            if ($this->request->getPost("page") == "valides") {
                $tmpValidateUserArray = [];
                $tmpResponse = (json_decode(HTTPRequester::HTTPPost($baseUrl . "/apis/users/search", ["key" => $this->request->getPost("key"), "value" => $this->request->getPost("value"), "userStatus" => "user"])));
                if (!isset($tmpResponse->status)) {
                    foreach ($tmpResponse as $tmp) {
                        $tmpValidateUserArray[] = get_object_vars($tmp);
                    }
                }
            }

            foreach ($tmpValidateUserArray as $key => $tmpUser) {
                $data["validateUserArray"][$key] = $tmpUser;
                $data["validateUserArray"][$key]["parrain"] = $userModel->find(($sponsorshipsModel->where(["godDauhterToken" => $tmpUser["token"]])->first())["godFatherToken"]);
                $data["validateUserArray"][$key]["package"] = $packageModel->find(($subscribedPackagesModel->where(["userToken" => $tmpUser["token"]])->first())["packageToken"]);
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
