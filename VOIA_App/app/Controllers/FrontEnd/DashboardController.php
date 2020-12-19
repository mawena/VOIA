<?php

namespace App\Controllers\FrontEnd;

use Config\Services;
use App\Libraries\Helper;
use App\Models\UserModel;
use CodeIgniter\Controller;


class DashboardController extends Controller
{
    public function dashboard()
    {
        $session = Services::session();
        $model = new UserModel();
        if (isset($_SESSION['currentUser'])) {
            $data["title"] = ["Tableau de bord"];
            $baseUrl = Helper::getBaseUrl();

            $currentSubscribedPackage = get_object_vars(json_decode(file_get_contents($baseUrl . "/apis/subscribedPackages/users/get/" . $_SESSION["currentUser"]["token"])));
            

            if (isset($currentSubscribedPackage["status"]) && $currentSubscribedPackage["status"] == "failed") {
                $currentSubscribedPackage = [];
            } else {
                $currentSubscribedPackage["package"] = get_object_vars(json_decode(file_get_contents($baseUrl . "/apis/packages/get/" . $currentSubscribedPackage["packageToken"])));
                $currentSubscribedPackage["package"]["product"] = get_object_vars($currentSubscribedPackage["package"]["product"]);
                $currentSubscribedPackage["length"] = $currentSubscribedPackage["package"]["timeOut"];
            }
            $currentSponsorshipArray = json_decode(file_get_contents($baseUrl . "/apis/sponsorships/godFather/get/" . $_SESSION["currentUser"]["token"]));
            
            if (isset($currentSponsorshipArray->status) && $currentSponsorshipArray->status == "failed") {
                $Sponsors = [];
            } else {
                foreach ($currentSponsorshipArray as $sponsorship) {
                    $Sponsors[] = get_object_vars(json_decode(file_get_contents($baseUrl . "/apis/users/get/" . (get_object_vars($sponsorship))["godDauhterToken"])));
                }
            }

            $data["subscribedPackage"] = $currentSubscribedPackage;
            $data["sponsors"] = $Sponsors;
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
