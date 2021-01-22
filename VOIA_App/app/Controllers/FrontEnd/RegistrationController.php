<?php

namespace App\Controllers\FrontEnd;

use App\Libraries\Helper;
use App\Models\PackagesModel;
use App\Models\UserModel;
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
        $parrainUserPackage = null;

        if ($parainMatricule == null or $slugPackage == null) {
            return redirect()->to("/");
        } else {
            $packageSlugArray = [];
            $packageArray = (json_decode(file_get_contents(Helper::getBaseUrl() . "/apis/packages")));
            foreach ($packageArray as $key => $tmpPackage) {
                $packageArray[$key] = get_object_vars($tmpPackage);
                $packageArray[$key]["product"] = get_object_vars($packageArray[$key]["product"]);
                $packageSlugArray[] = $packageArray[$key]["slug"];
            }

            if (in_array($slugPackage, $packageSlugArray)) {
                $parrainUser = get_object_vars(json_decode(file_get_contents(Helper::getBaseUrl() . "/apis/parains/get/" . $parainMatricule)));
                if (isset($parrainUser["status"]) && $parrainUser["status"] == "failed") {
                    return redirect()->to("/");
                } else {
                    $firstParain = ((new UserModel())->orderBy("admissionDate")->findAll())[0];
                    if ($parainMatricule != $firstParain["matricule"]) {
                        $parrainUserPackage = $packageModel->where(['token' => $subscribedPackagesModel->where(["userToken" => $parrainUser["token"]])->first()['packageToken']])->first()['slug'];
                        if ($parrainUserPackage != "") {
                            if (in_array($parrainUserPackage, ["niveau-1", "niveau-2"])) {
                                if (!in_array($slugPackage, ["niveau-1", "niveau-2"])) {
                                    return redirect()->to('/');
                                }
                            } else {
                                if ($slugPackage != $parrainUserPackage) {
                                    return redirect()->to('/');
                                }
                            }
                        } else {
                            return redirect()->to('/');
                        }
                    }
                }
            } else {
                return redirect()->to("/");
            }
        }

        $data = [
            "title" => "Inscription",
            "parrainUser" => $parrainUser,
            "slugPackage" => $slugPackage,
        ];
        echo view('templates/header', $data);
        echo view('templates/nav');
        echo view('pages/inscription', $data);
        echo view('templates/footer');
    }
}
