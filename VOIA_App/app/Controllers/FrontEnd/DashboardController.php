<?php

namespace App\Controllers\FrontEnd;

use Config\Services;
use App\Libraries\Helper;
use App\Models\SubscribedPackagesModel;
use App\Models\UserModel;
use CodeIgniter\Controller;


class DashboardController extends Controller
{
    public function dashboard()
    {
        $session = Services::session();
        $baseUrl = Helper::getBaseUrl();
        $userModel = new UserModel();
        $subscribedPackagesModel = new SubscribedPackagesModel();
        if (isset($_SESSION['currentUser'])) {
            $data["title"] = ["Tableau de bord"];

            
            //Gestion du package souscrit
            $currentSubscribedPackage = get_object_vars(json_decode(file_get_contents($baseUrl . "/apis/subscribedPackages/users/get/" . $_SESSION["currentUser"]["token"])));
            if (isset($currentSubscribedPackage["status"]) && $currentSubscribedPackage["status"] == "failed") {
                $currentSubscribedPackage = [];
            } else {
                $currentSubscribedPackage["package"] = get_object_vars(json_decode(file_get_contents($baseUrl . "/apis/packages/get/" . $currentSubscribedPackage["packageToken"])));
                $currentSubscribedPackage["package"]["product"] = get_object_vars($currentSubscribedPackage["package"]["product"]);
                $currentSubscribedPackage["length"] = $currentSubscribedPackage["package"]["timeOut"];
            }

            //Gestion des fieulles 
            $currentSponsorshipArray = json_decode(file_get_contents($baseUrl . "/apis/sponsorships/godFather/get/" . $_SESSION["currentUser"]["token"]));
            if (isset($currentSponsorshipArray->status) && $currentSponsorshipArray->status == "failed") {
                $sponsorArray = [];
            } else {
                foreach ($currentSponsorshipArray as $sponsorship) {
                    $tmpUser = get_object_vars(json_decode(file_get_contents($baseUrl . "/apis/users/get/" . (get_object_vars($sponsorship))["godDauhterToken"])));
                    $tmpUser["subscribedPackage"] = get_object_vars(json_decode(file_get_contents($baseUrl . "/apis/subscribedPackages/users/get/" . $tmpUser["token"])));
                    $tmpUser["package"] = get_object_vars(json_decode(file_get_contents($baseUrl . "/apis/packages/get/" . $tmpUser["subscribedPackage"]["packageToken"])));
                    $tmpUser["package"]["product"] = get_object_vars($tmpUser["package"]["product"]);
                    $sponsorArray[$tmpUser["package"]["slug"]][] = $tmpUser;
                }
            }

            $data["subscribedPackage"] = $currentSubscribedPackage;
            $data["sponsors"] = $sponsorArray;
            $data["currentUser"] = $_SESSION["currentUser"];

            echo view('templates/header.php', $data);
            echo view('templates/nav.php', $data);
            echo view('pages/dashboard.php', $data);
            echo view('templates/footer.php', $data);
        } else {
            return redirect()->to("/connexion");
        }
    }
}
