<?php

namespace App\Controllers\Apis;

use App\Models\SubscribedPackagesModel;
use App\Models\PackagesModel;
use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class SubscribedPackagesController extends ResourceController
{
    /**
     * Retourn les informations d'une souscription à un package
     *
     * @param string $token
     * @return void
     */
    public function getSubscribedPackage(string $token = null)
    {
        if ($token == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "L'identifiant de la souscription est manquante!"
            ]);
        } else {
            $currentSubscribedPackage = (new SubscribedPackagesModel())->find($token);
            if ($currentSubscribedPackage == [] or $currentSubscribedPackage == null) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "La souscription n'existe pas!"
                ]);
            } else {
                return $this->respond($currentSubscribedPackage);
            }
        }
    }

    /**
     * Retourne les informations d'une souscription à l'aide du token de l'utilisateur
     *
     * @param string $userToken
     * @return void
     */
    public function getUserSubscribedPackage(string $userToken = null)
    {
        if ($userToken == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "L'identifiant de l'utilisateur est manquant!"
            ]);
        } else {
            if ((new UserModel())->find($userToken) == null) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "L'utilisateur n'existe pas!"
                ]);
            } else {
                $currentSubscribedPackage = (new SubscribedPackagesModel())->where(["userToken" => $userToken])->first();
                if ($currentSubscribedPackage == [] or $currentSubscribedPackage == null) {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "L'utilisateur n'a souscrit à aucun package!"
                    ]);
                } else {
                    return $this->respond($currentSubscribedPackage);
                }
            }
        }
    }

    /**
     * Retourne toutes les souscriptions, ou les suscriptions d'un utilisateur
     *
     * @param string $userToken
     * @return void
     */
    public function getAllSubscribedPackage(string $userToken = null)
    {
        $subscribedPackagesModel = new SubscribedPackagesModel();
        if ($userToken == null) {
            $currentSubscribedPackageArray = $subscribedPackagesModel->orderBy("subscriptionDate", "DESC")->findAll();
            if ($currentSubscribedPackageArray == []) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Il n'y a aucune souscription pour le moment!"
                ]);
            } else {
                return $this->respond($currentSubscribedPackageArray);
            }
        } else {
            if ((new UserModel())->find($userToken) == []) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "L'utilsateur n'est pas inscrit!"
                ]);
            } else {
                $currentSubscribedPackageArray = $subscribedPackagesModel->asArray()->where(["userToken" => $userToken])->findAll();
                if ($currentSubscribedPackageArray == []) {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "L'utilisateur n'a effectué aucune souscription pour le moment!"
                    ]);
                } else {
                    return $this->respond($currentSubscribedPackageArray);
                }
            }
        }
    }

    /**
     * Ajoute une souscription à la bdd
     *
     * @return json
     */
    public function storeSubscribedPackage()
    {
        date_default_timezone_set('UTC');
        $subscribedPackagesModel = new SubscribedPackagesModel();
        if ($this->request->getMethod() == "post") {
            if ($this->validate(["userToken" => "required"])) {
                $currentSubscribedPackage["userToken"] = $this->request->getPost("userToken");
                if ((new UserModel())->find($currentSubscribedPackage["userToken"]) == null) {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "L'utilisateur indiqué n'est pas inscrit!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "L'identifiant de l'utilisateur est manquant!"
                ]);
            }

            if ($this->validate(["packageToken" => "required"])) {
                $currentSubscribedPackage["packageToken"] = $this->request->getPost("packageToken");
                if ((new PackagesModel())->find($currentSubscribedPackage["packageToken"]) == null) {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le package demandé n'existe pas!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le package est manquant!"
                ]);
            }

            if (($subscribedPackagesModel->asArray()->where(["userToken" => $currentSubscribedPackage["userToken"], "packageToken" => $currentSubscribedPackage["packageToken"]])->first()) == []) {
                $currentSubscribedPackage["token"] = sha1($currentSubscribedPackage["userToken"] . $currentSubscribedPackage["packageToken"]);
                $currentSubscribedPackage["subscriptionDate"] = time();

                $subscribedPackagesModel->insert($currentSubscribedPackage);
                return $this->respond([
                    "status" => "success",
                    "data" => $currentSubscribedPackage
                ]);
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Cet utilisateur à déja souscrit à ce package!"
                ]);
            }
        } else {
            return $this->respond([
                "status" => "failed",
                "message" => "Vous devez envoyer les données via un formulaire 'post'!"
            ]);
        }
    }

    /**
     * Met à jour une souscription dans la bdd
     *
     * @param string $token
     * @return json
     */
    public function updateSubscribedPackage(string $token = null)
    {
        date_default_timezone_set('UTC');
        $subscribedPackagesModel = new SubscribedPackagesModel();
        if ($token == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "L'identifiant de la souscription est manquant!"
            ]);
        } else {
            if ($this->request->getMethod() == "post") {
                $dataBaseSubscribedPackage = $subscribedPackagesModel->find($token);

                if ($dataBaseSubscribedPackage == null) {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "La souscription demandé n'existe pas!"
                    ]);
                }

                if ($this->validate(["userToken" => "required"])) {
                    $currentSubscribedPackage["userToken"] = $this->request->getPost("userToken");
                    if ((new UserModel())->find($currentSubscribedPackage["userToken"]) == null) {
                        return $this->respond([
                            "status" => "failed",
                            "message" => "L'utilisateur indiqué n'est pas inscrit!"
                        ]);
                    }
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "L'identifiant de l'utilisateur est manquant!"
                    ]);
                }

                if ($this->validate(["packageToken" => "required"])) {
                    $currentSubscribedPackage["packageToken"] = $this->request->getPost("packageToken");
                    if ((new PackagesModel())->find($currentSubscribedPackage["packageToken"]) == null) {
                        return $this->respond([
                            "status" => "failed",
                            "message" => "Le package demandé n'existe pas!"
                        ]);
                    }
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le package est manquant!"
                    ]);
                }

                $currentSubscribedPackage["token"] = $token;
                $currentSubscribedPackage["subscriptionDate"] = $dataBaseSubscribedPackage["subscriptionDate"];
                $subscribedPackagesModel->save($currentSubscribedPackage, "token = " . $token);
                return $this->respond([
                    "status" => "success",
                    "data" => $currentSubscribedPackage
                ]);
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Vous devez envoyer les données via un formulaire 'post'!"
                ]);
            }
        }
    }

    /**
     * Retire une souscription de la bdd
     *
     * @param string $token
     * @return void
     */
    public function deleteSubscribedPackage(string $token = null)
    {
        $subscribedPackagesModel = new SubscribedPackagesModel();
        if ($token == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "L'identifiant de la souscription est manquant!"
            ]);
        } else {
            if ($subscribedPackagesModel->find($token) == null) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "La souscription n'existe pas!"
                ]);
            } else {
                $subscribedPackagesModel->delete($token);
                return $this->respond([
                    "status" => "success"
                ]);
            }
        }
    }
}
