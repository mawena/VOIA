<?php

namespace App\Controllers\Apis;

use App\Models\UserModel;
use App\Models\CountryModel;
use App\Models\PackagesModel;
use App\Models\UserWaitingModel;
use App\Models\SponsorshipsModel;
use App\Models\SubscribedPackagesModel;
use CodeIgniter\RESTful\ResourceController;

class UsersController extends ResourceController
{
    /**
     * Retourne les informations d'un utilisateur
     *
     * @param string $token
     * @return json
     */
    public function getUser(string $token = null)
    {
        $userModel = new UserModel();
        if ($token == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "L'identifiant de l'utilisateur est manquant!"
            ]);
        } else {
            $currentUser = $userModel->find($token);
            if ($currentUser == [] or $currentUser == null) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "L'utilisateur n'est pas inscrit!"
                ]);
            } else {
                return $this->respond($currentUser);
            }
        }
    }

    /**
     * Retourne les informations d'un utilisateur à l'aide de son matricule
     *
     * @param string $parainMatricule
     * @return void
     */
    public function getParain(string $parainMatricule = null)
    {
        $userModel = new UserModel();
        if ($parainMatricule == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "Le matricule du parain est manquant!"
            ]);
        } else {
            $currentParain = $userModel->where(["matricule" => $parainMatricule])->first();
            if ($currentParain == [] or $currentParain == null) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "L'utilisateur demandé n'existe pas!"
                ]);
            } else {
                return $this->respond($currentParain);
            }
        }
    }

    /**
     * Retourne les informations de tout les utilisateurs
     *
     * @return json
     */
    public function getAllUser()
    {
        $userModel = new UserModel();
        $currentUserArray = $userModel->orderBy("admissionDate", "DESC")->findAll();
        if ($currentUserArray == [] or $currentUserArray == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "Il n'y a aucun utilisateur pour le moment!"
            ]);
        } else {
            return $this->respond($currentUserArray);
        }
    }

    /**
     * Retourne la liste des commerciaux
     *
     * @return json
     */
    public function getAllCommercialUser()
    {
        $userModel = new UserModel();
        $currentCommercialUserArray = $userModel->where(["type" => "communicateur"])->findAll();
        if ($currentCommercialUserArray == [] or $currentCommercialUserArray == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "Il n'y aucun communicateur pour le momment"
            ]);
        } else {
            return $this->respond($currentCommercialUserArray);
        }
    }

    /**
     * Retourne les filleuls d'un utilisateur 
     *
     * @param string $godFatherToken
     * @return void
     */
    public function getAllGodDauhter(string $godFatherToken = null)
    {
        $userModel = new UserModel();
        $sponsorshipsModel = new SponsorshipsModel();
        $subscribedPackagesModel = new SubscribedPackagesModel();
        $packagesModel = new PackagesModel();
        if ($godFatherToken == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "L'identifiant du parrain est manquant!"
            ]);
        } else {
            $currentGodFatherToken = $userModel->find($godFatherToken);
            if ($currentGodFatherToken == null) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le parrain demandé n'existe pas!"
                ]);
            } else {
                $currentSponsorshipsArray = $sponsorshipsModel->where(["godFatherToken" => $godFatherToken])->findAll();
                if ($currentSponsorshipsArray == [] or $currentSponsorshipsArray == null) {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Ce parrain n'a aucun filleul pour le moment!"
                    ]);
                } else {
                    $currentGodDauhterArray = [];
                    foreach ($currentSponsorshipsArray as $key => $tmpSponsorship) {
                        $tmpGodDauhter = $userModel->find($tmpSponsorship["godDauhterToken"]);
                        $tmpGodDauhterPackage = $packagesModel->find(($subscribedPackagesModel->where(["userToken" => $tmpGodDauhter["token"]])->first())["packageToken"]);
                        $currentGodDauhterArray[$tmpGodDauhterPackage["slug"]][] = $tmpGodDauhter;
                    }
                    return $this->respond($currentGodDauhterArray);
                }
            }
        }
    }

    /**
     * Ajoute un utilisateur à la base de données
     *
     * @param string $token
     * @return void
     */
    public function storeUser()
    {
        date_default_timezone_set('UTC');
        $method = "post";
        $countryNameArray = [];
        $userModel = new UserModel();
        $userWaitingModel = new UserWaitingModel();
        $subscribedPackagesModel = new SubscribedPackagesModel();
        $subscribedPackagesModel = new PackagesModel();
        $countryModel = new CountryModel();

        if ($this->request->getMethod() == $method) {
            $currentUser["username"] = $this->request->getPost("username");
            if ($this->validate(["username" => "required"])) {
                if ($this->validate(["username" => "min_length[2]"])) {
                    if ($userWaitingModel->where(["username" => $currentUser["username"]])->first() == null) {
                        if ($userModel->where(["username" => $currentUser["username"]])->first() != null) {
                            return $this->respond([
                                "status" => "failed",
                                "message" => "L'identifiant '" . $currentUser["username"] . "' est déja inscrit. Veuillez en chosir un autre!"
                            ]);
                        }
                    } else {
                        return $this->respond([
                            "status" => "failed",
                            "message" => "L'identifiant '" . $currentUser["username"] . "' est déja en liste d'attente. Veuillez en chosir un autre!"
                        ]);
                    }
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "L'identifiant doit contenir au moins 2 caractères!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "L'identifiant est manquant!"
                ]);
            }
            if ($this->validate(["password" => "required"])) {
                if ($this->validate(["password" => "min_length[8]"])) {
                    $currentUser["password"] = password_hash($this->request->getPost("password"), PASSWORD_BCRYPT);
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le mot de passe doit contenir au moins 8 caractères!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le mot de passe est manquant!"
                ]);
            }

            if ($this->validate(["type" => "required"])) {
                if ($this->validate(["type" => "in_list[normal,communicateur]"])) {
                    $currentUser["type"] = $this->request->getPost("type");
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le type de l'utilisateur doit être 'normal' ou 'communicateur'"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le type de l'utilisateur est manquant!"
                ]);
            }

            if ($this->validate(["last_name" => "required"])) {
                if ($this->validate(["last_name" => "min_length[2]"])) {
                    $currentUser["last_name"] = $this->request->getPost("last_name");
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le nom de famille doit contenir au moins 2 caractères!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le nom de famille est manquant!"
                ]);
            }

            if ($this->validate(["first_name" => "required"])) {
                if ($this->validate(["first_name" => "min_length[2]"])) {
                    $currentUser["first_name"] = $this->request->getPost("first_name");
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le prénom doit contenir au moins 2 caractères!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le prénom est manquant!"
                ]);
            }

            if ($this->validate(["email" => "required"])) {
                if ($this->validate(["email" => "valid_email"])) {
                    $currentUser["email"] = $this->request->getPost("email");
                    if ($userModel->asArray()->where(["email" => $currentUser["email"]])->first() != []) {
                        return $this->respond(["status" => "failed", "message" => "L'adresse mail '" . $currentUser["email"] . "' est déjà utilisé"]);
                    }
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "L'email '" . $this->request->getPost("email") . "' n'est pas valide!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "L'email est manquant!"
                ]);
            }

            if ($this->validate(["sex" => "required"])) {
                if ($this->validate(["sex" => "in_list[Homme,Femme]"])) {
                    $currentUser["sex"] = $this->request->getPost("sex");
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le sexe doit être 'Homme' ou 'Femme'!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le sexe est manquant!"
                ]);
            }

            if ($this->validate(["numero" => "required"])) {
                if ($this->validate(["numero" => "min_length[4]"])) {
                    $currentUser["phoneNumber"] = $this->request->getPost("numero");
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le numéro de téléphone doit contenir au moins quatre chiffres!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le numéro de téléphone est manquant!"
                ]);
            }

            if ($this->validate(["numero_whatsapp" => "required"])) {
                if ($this->validate(["numero_whatsapp" => "min_length[4]"])) {
                    $currentUser["whatsappNumber"] = $this->request->getPost("numero_whatsapp");
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le numéro whatsapp doit contenir au moins quatre chiffres!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le contact whatsapp est manquant!"
                ]);
            }

            foreach ($countryModel->findAll() as $countryDataArray) {
                $countryNameArray[] = $countryDataArray["nom_fr_fr"];
            }

            if ($this->validate(["country" => "required"])) {
                $currentUser["country"] = $this->request->getPost("country");
                if (!in_array($currentUser["country"], $countryNameArray)) {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le pays '" . $currentUser["country"] . "' n'est pas valide!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le pays est manquant!"
                ]);
            }

            $currentUser["token"] = sha1($currentUser["username"] . $currentUser["last_name"] . $currentUser["first_name"] . date("Y-m-d H:i:s"));
            if ($this->validate(["codeParainage" => "required"])) {
                $currentUser["codeParainage"] = $this->request->getPost("codeParainage");
                $godFatherUser = $userModel->asArray()->where(["matricule" => $currentUser["codeParainage"]])->first();
                if ($godFatherUser == null or $godFatherUser == []) {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le code de parainage que vous avez utilisé n'existe pas!"
                    ]);
                } else {
                    (new SponsorshipsModel())->insert([
                        "token" => sha1($currentUser["token"] . $godFatherUser["token"]),
                        "godFatherToken" => $godFatherUser["token"],
                        "godDauhterToken" => $currentUser["token"]
                    ]);
                }
            }

            $currentUser["matricule"] =  $userModel->countAll() . date("y") . date("s") . $currentUser["username"]["1"] . $userModel->getLastedId() . date("d") . date("j");
            $currentUser["admissionDate"] = date("Y-m-d H:i:s");

            $userModel->insert($currentUser);
            return $this->respond([
                "status" => "success",
            ]);
        } else {
            return $this->respond([
                "status" => "failed",
                "message" => "Vous devez passer par la méthode '" . $method . "' pour acéder à ce lien"
            ]);
        }
    }

    /**
     * Met à jour les informations d'un utilisateur dans la base de données
     *
     * @param string $userToken
     * @return json
     */
    public function updateUser(string $userToken = null)
    {
        $method = "post";
        $userModel = new UserModel();
        if ($this->request->getMethod() == $method) {
            if ($userToken == null) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "L'identifiant de l'utilisateur est manquant!"
                ]);
            } else {
                $dataBaseUser = $userModel->find($userToken);
                if ($dataBaseUser == null) {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "L'utilisateur n'existe pas!"
                    ]);
                }

                if ($this->validate(["username" => "required"])) {
                    if ($this->validate(["username" => "min_length[2]"])) {
                        $currentUser["username"] = $this->request->getPost("username");
                    } else {
                        return $this->respond([
                            "status" => "failed",
                            "message" => "Le nom d'utilsateur doit contenir au moins deux caractères!"
                        ]);
                    }
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le nom d'utilisateur est manquant!"
                    ]);
                }

                if (isset($_POST["password"]) && !empty($_POST["password"])) {
                    if ($this->validate(["password" => "min_length[8]"])) {
                        if ($this->validate(["oldPassword" => "required"])) {
                            $oldPassword = $this->request->getPost("oldPassword");
                            // if (password_verify($oldPassword, $dataBaseUser["password"])) {
                            if ($oldPassword == $dataBaseUser["password"]) {
                                $currentUser["password"] = password_hash($this->request->getPost("password"), PASSWORD_BCRYPT);
                            } else {
                                return $this->respond([
                                    "status" => "failed",
                                    "message" => "L'ancien mot de passe est incorrect!",
                                ]);
                            }
                        } else {
                            return $this->respond([
                                "status" => "failed",
                                "message" => "L'ancien mot de passe est manquant!"
                            ]);
                        }
                    } else {
                        return $this->respond([
                            "status" => "failed",
                            "message" => "Le nouveau mot de passe doit contenir au moins 8 caractères!"
                        ]);
                    }
                }

                if ($this->validate(["type" => "required"])) {
                    if ($this->validate(["type" => "in_list[normal,communicateur]"])) {
                        $currentUser["type"] = $this->request->getPost("type");
                    } else {
                        return $this->respond([
                            "status" => "failed",
                            "message" => "Le type de l'utilisateur doit être 'normal' ou 'communicateur'"
                        ]);
                    }
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le type de l'utilisateur est manquant!"
                    ]);
                }

                if ($this->validate(["last_name" => "required"])) {
                    if ($this->validate(["last_name" => "min_length[2]"])) {
                        $currentUser["last_name"] = $this->request->getPost("last_name");
                    } else {
                        return $this->respond([
                            "status" => "failed",
                            "message" => "Le nom de famille doit contenir au moins deux caractères!"
                        ]);
                    }
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le nom de famille est manquant!"
                    ]);
                }

                if ($this->validate(["first_name" => "required"])) {
                    if ($this->validate(["first_name" => "min_length[2]"])) {
                        $currentUser["first_name"] = $this->request->getPost("first_name");
                    } else {
                        return $this->respond([
                            "status" => "failed",
                            "message" => "Le prénom doit contenir au moins deux caractères!"
                        ]);
                    }
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le prénom est manquant!"
                    ]);
                }

                if ($this->validate(["email" => "required"])) {
                    if ($this->validate(["email" => "valid_email"])) {
                        $currentUser["email"] = $this->request->getPost("email");
                        if ($userModel->asArray()->where(["email" => $currentUser["email"]])->first() != [] && $currentUser["email"] != $dataBaseUser["email"]) {
                            return $this->respond(["status" => "failed", "message" => "L'adresse mail '" . $currentUser["email"] . "' est déjà utilisé"]);
                        }
                    } else {
                        return $this->respond([
                            "status" => "failed",
                            "message" => "L'email n'est pas valide!"
                        ]);
                    }
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "L'email est manquant!"
                    ]);
                }

                if ($this->validate(["sex" => "required"])) {
                    if ($this->validate(["sex" => "in_list[Homme,Femme]"])) {
                        $currentUser["sex"] = $this->request->getPost("sex");
                    } else {
                        return $this->respond([
                            "status" => "failed",
                            "message" => "Le sexe doit être 'Homme' ou 'Femme'!"
                        ]);
                    }
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le sexe est manquant!"
                    ]);
                }

                $currentUser["token"] = $userToken;
                $userModel->save($currentUser, "token = " . $userToken);
                return $this->respond([
                    "status" => "success",
                    "data" => $currentUser
                ]);
            }
        } else {
            return $this->respond([
                "status" => "failed",
                "message" => "Vous devez passer par la méthode '" . $method . "' pour acéder à ce lien"
            ]);
        }
    }

    /**
     * Suprime un utilisateur
     *
     * @param string $token
     * @return json
     */
    public function deleteUser(string $token = null)
    {
        $userModel = new UserModel();
        $subscribedPackagesModel = new SubscribedPackagesModel();
        $sponsorshipsModel = new SponsorshipsModel();
        if ($token == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "L'identifiant de l'utilisateur est manquant!"
            ]);
        } else {
            if ($userModel->find($token) == null) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "L'utilisateur n'est pas inscrit!"
                ]);
            } else {
                $currentSubscribedPackageArray = $subscribedPackagesModel->where(["userToken" => $token])->findAll();
                if ($currentSubscribedPackageArray != [] || $currentSubscribedPackageArray != null) {
                    foreach ($currentSubscribedPackageArray as $currentSubscribedPackage) {
                        $subscribedPackagesModel->delete($currentSubscribedPackage["token"]);
                    } //Supréssion de la souscrition à un package
                }

                $currentGodFather = ($sponsorshipsModel->where(["godDauhterToken" => $token])->first());
                if ($currentGodFather != null) {
                    $sponsorshipsModel->delete($currentGodFather["token"]);   //Supréssion du parrainage
                }

                $userModel->delete($token); //Supréssion de l'utilisateur
                return $this->respond([
                    "status" => "success"
                ]);
            }
        }
    }
}
