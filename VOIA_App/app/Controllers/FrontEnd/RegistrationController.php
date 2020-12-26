<?php

namespace App\Controllers\FrontEnd;

use App\Libraries\Helper;
use App\Models\PackagesModel;
use App\Models\SubscribedPackagesModel;
use CodeIgniter\Controller;

class RegistrationController extends Controller
{

    /**
     * Gère la page d'inscription
     *
     * @param string $parainToken
     * @return void
     */
    public function registration(string $parainMatricule = null, string $slugPackage = null)
    {
        $subscribedPackagesModel = new SubscribedPackagesModel();
        $packageModel = new PackagesModel();
        $data = [];

        if ($parainMatricule == null or $slugPackage == null) {
            return redirect()->to("/");
        } else {
            if($slugPackage == "niveau-1" or $slugPackage == "niveau-2"){
                $parrainUser = get_object_vars(json_decode(file_get_contents(Helper::getBaseUrl() . "/apis/parains/get/" . $parainMatricule)));
                if (isset($parrainUser["status"]) && $parrainUser["status"] == "failed") {
                    return redirect()->to("/");
                } else {
                    if ($parrainUser["type"] == "normal") {
                        $parrainUser["package"] = $packageModel->find($subscribedPackagesModel->where(["userToken" => $parrainUser["token"]])->first());
                        if ($parrainUser["package"][0]["slug"] != $slugPackage) {
                            return redirect()->to("/");
                        }
                    }
                }
            }else{
                return redirect()->to("/");
            }
        }

        $data = [
            "title" => "Inscription",
            "parrainUser" => $parrainUser,
            "slugPackage" => $slugPackage
        ];
        echo view('templates/header', $data);
        echo view('templates/nav');
        echo view('pages/inscription', $data);
        echo view('templates/footer');
    }
}
