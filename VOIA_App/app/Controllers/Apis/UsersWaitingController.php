<?php

namespace App\Controllers\Apis;

use App\Models\UserModel;
use App\Models\CountryModel;
use App\Models\PackagesModel;
use App\Models\UserWaitingModel;
use App\Models\SponsorshipsModel;
use App\Models\SubscribedPackagesModel;
use CodeIgniter\RESTful\ResourceController;

class UsersWaitingController extends ResourceController
{
    /**
     * Retourne les informations d'un utilisateur
     *
     * @param string $token
     * @return json
     */
    public function getUserWaiting(string $token = null)
    {
        $userWaitingModel = new UserWaitingModel();
        if ($token == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "L'identifiant de l'utilisateur est manquant!"
            ]);
        } else {
            $currentUser = $userWaitingModel->find($token);
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
    public function getParainWaiting(string $parainMatricule = null)
    {
        $userWaitingModel = new UserWaitingModel();
        if ($parainMatricule == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "Le matricule du parain est manquant!"
            ]);
        } else {
            $currentParain = $userWaitingModel->where(["matricule" => $parainMatricule])->first();
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
    public function getAllUserWaiting()
    {
        $userWaitingModel = new UserWaitingModel();
        $currentUserArray = $userWaitingModel->orderBy("admissionDate", "DESC")->findAll();
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
     * Transfert l'utilisateur dans la liste des validé
     *
     * @param string $token
     * @return void
     */
    public function validateUserWaiting(string $token = null)
    {
        $packageModel = new PackagesModel();
        $sponsorshipsModel = new SponsorshipsModel();
        $subscribedPackagesModel = new SubscribedPackagesModel();
        $userModel = new UserModel();
        $userWaitingModel = new UserWaitingModel();
        if ($token == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "L'identifiant du l'utilisateur en attente est manquant!"
            ]);
        } else {
            $currentUserWaiting = $userWaitingModel->find($token);
            if ($currentUserWaiting == null) {
                if ($userModel->find($token)) {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "L'utilisateur est déja inscrit!"
                    ]);
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "L'utilisateur demandé n'est pas encore inscrit!"
                    ]);
                }
            } else {
                $currentParain = $userModel->where(["matricule" => $currentUserWaiting["codeParainnage"]])->first();
                if ($currentParain == null) {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le parrain de l'utilisateur n'est pas inscrit!"
                    ]);
                } else {

                    $currentUserWaiting["package"] = $packageModel->where(["slug" => $currentUserWaiting["slugPackage"]])->first();
                    if (count($sponsorshipsModel->where(["godFatherToken" => $currentParain["token"]])->findAll()) >= (int) ($currentUserWaiting["package"]["numberPerson"]) && $currentParain["type"] != "commercial") {
                        // $parrainSuscribedPackage = $subscribedPackagesModel->where(["packageToken" => $currentUserWaiting["package"]["token"]])->orderBy("subscriptionDate")->first();
                        // $currentParain = $userModel->find($parrainSuscribedPackage["userToken"]);
                        $currentParain = ($userModel->orderBy("admissionDate")->findAll())[0];
                    } // Si le quotta du package est atteint et que le parrain n'est pas un commercial on met le premier inscrit avec le même package comme parrain

                    $subscribedPackagesModel->insert([
                        "token" => sha1($currentUserWaiting["token"] . $currentUserWaiting["package"]["token"]),
                        "userToken" => $currentUserWaiting["token"],
                        "packageToken" => $currentUserWaiting["package"]["token"],
                        "subscriptionDate" => time()
                    ]);

                    ($sponsorshipsModel)->insert([
                        "token" => sha1($currentParain["token"] . $currentUserWaiting["token"]),
                        "godFatherToken" => $currentParain["token"],
                        "godDauhterToken" => $currentUserWaiting["token"]
                    ]);

                    unset($currentUserWaiting["codeParainnage"]);
                    unset($currentUserWaiting["slugPackage"]);
                    $currentUserWaiting["admissionDate"] = date("Y-m-d H:i:s");
                    $userModel->insert($currentUserWaiting);
                    $userWaitingModel->delete($token);
                    return $this->respond([
                        "status" => "success",
                        "data" => $currentUserWaiting
                    ]);
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
    public function storeUserWaiting()
    {
        date_default_timezone_set('UTC');
        $method = "post";
        $countryNameArray = [];
        $userWaitingModel = new UserWaitingModel();
        $userModel = new UserModel();
        $countryModel = new CountryModel();
        $packageModel = new PackagesModel();
        $subscribedPackagesModel = new SubscribedPackagesModel();

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
                        return $this->respond([
                            "status" => "failed",
                            "message" => "L'adresse mail '" . $currentUser["email"] . "' est déjà utilisé"
                        ]);
                    }
                    if ($userWaitingModel->asArray()->where(["email" => $currentUser["email"]])->first() != []) {
                        return $this->respond([
                            "status" => "failed",
                            "message" => "L'adresse mail '" . $currentUser["email"] . "' est déjà utilisé"
                        ]);
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

            if ($this->validate(["slugPackage" => "required"])) {
                $currentUser["slugPackage"] = $this->request->getPost("slugPackage");
                if ($packageModel->where(["slug" => $currentUser["slugPackage"]])->first() == null) {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le mot package désigné n'existe pas!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le mot clé du package est manquant!"
                ]);
            }

            $currentUser["token"] = sha1($currentUser["username"] . $currentUser["last_name"] . $currentUser["first_name"] . date("Y-m-d H:i:s"));
            if ($this->validate(["codeParainnage" => "required"])) {
                $currentUser["codeParainnage"] = $this->request->getPost("codeParainnage");
                $godFatherUser = $userModel->where(["matricule" => $currentUser["codeParainnage"]])->first();
                if ($godFatherUser == null or $godFatherUser == []) {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le code de parainage que vous avez utilisé n'existe pas!"
                    ]);
                } else {
                    $godFatherUser["package"] = $packageModel->find($subscribedPackagesModel->where(["userToken" => $godFatherUser["token"]])->first())[0];
                    if ($godFatherUser["type"] != "commercial") {
                        // return $this->respond($godFatherUser["package"]);
                        if ($godFatherUser["package"]["slug"] != $currentUser["slugPackage"]) {
                            return $this->respond([
                                "status" => "failed",
                                "message" => "Vous devez souscrire au même package que votre parrain!"
                            ]);
                        }
                    }
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le code de parainage est manquant!"
                ]);
            }
            $currentUser["type"] = "normal";
            $currentUser["matricule"] =  $userWaitingModel->countAll() . date("y") . date("s") . $currentUser["username"]["1"] . $userWaitingModel->getLastedId() . date("d") . date("j");
            $currentUser["admissionDate"] = date("Y-m-d H:i:s");

            $userWaitingModel->insert($currentUser);
            return $this->respond([
                "status" => "success",
                "data" => $currentUser
            ]);
        } else {
            return $this->respond([
                "status" => "failed",
                "message" => "Vous devez passer par la méthode '" . $method . "' pour acéder à ce lien"
            ]);
        }
    }

    // /**
    //  * Met à jour les informations d'un utilisateur dans la base de données
    //  *
    //  * @param string $userToken
    //  * @return json
    //  */
    // public function updateUserWaiting(string $userToken = null)
    // {
    //     $method = "post";
    //     $userWaitingModel = new UserWaitingModel();
    //     $userModel = new UserModel();
    //     if ($this->request->getMethod() == $method) {
    //         if ($userToken == null) {
    //             return $this->respond([
    //                 "status" => "failed",
    //                 "message" => "L'identifiant de l'utilisateur est manquant!"
    //             ]);
    //         } else {
    //             $dataBaseUser = $userWaitingModel->find($userToken);
    //             if ($dataBaseUser == null) {
    //                 return $this->respond([
    //                     "status" => "failed",
    //                     "message" => "L'utilisateur n'existe pas!"
    //                 ]);
    //             }

    //             if ($this->validate(["username" => "required"])) {
    //                 if ($this->validate(["username" => "min_length[2]"])) {
    //                     $currentUser["username"] = $this->request->getPost("username");
    //                 } else {
    //                     return $this->respond([
    //                         "status" => "failed",
    //                         "message" => "Le nom d'utilsateur doit contenir au moins deux caractères!"
    //                     ]);
    //                 }
    //             } else {
    //                 return $this->respond([
    //                     "status" => "failed",
    //                     "message" => "Le nom d'utilisateur est manquant!"
    //                 ]);
    //             }

    //             if (isset($_POST["password"]) && !empty($_POST["password"])) {
    //                 if ($this->validate(["password" => "min_length[8]"])) {
    //                     if ($this->validate(["oldPassword" => "required"])) {
    //                         $oldPassword = $this->request->getPost("oldPassword");
    //                         if (password_verify($oldPassword, $dataBaseUser["password"])) {
    //                             $currentUser["password"] = $this->request->getPost("password");
    //                         } else {
    //                             return $this->respond([
    //                                 "status" => "failed",
    //                                 "message" => "L'ancien mot de passe est incorrect!"
    //                             ]);
    //                         }
    //                     } else {
    //                         return $this->respond([
    //                             "status" => "failed",
    //                             "message" => "L'ancien mot de passe est manquant!"
    //                         ]);
    //                     }
    //                 } else {
    //                     return $this->respond([
    //                         "status" => "failed",
    //                         "message" => "Le nouveau mot de passe doit contenir au moins 8 caractères!"
    //                     ]);
    //                 }
    //             }

    //             if ($this->validate(["type" => "required"])) {
    //                 if ($this->validate(["type" => "in_list[normal,commercial]"])) {
    //                     $currentUser["type"] = $this->request->getPost("type");
    //                 } else {
    //                     return $this->respond([
    //                         "status" => "failed",
    //                         "message" => "Le type de l'utilisateur doit être 'normal' ou 'commercial'"
    //                     ]);
    //                 }
    //             } else {
    //                 return $this->respond([
    //                     "status" => "failed",
    //                     "message" => "Le type de l'utilisateur est manquant!"
    //                 ]);
    //             }

    //             if ($this->validate(["last_name" => "required"])) {
    //                 if ($this->validate(["last_name" => "min_length[2]"])) {
    //                     $currentUser["last_name"] = $this->request->getPost("last_name");
    //                 } else {
    //                     return $this->respond([
    //                         "status" => "failed",
    //                         "message" => "Le nom de famille doit contenir au moins deux caractères!"
    //                     ]);
    //                 }
    //             } else {
    //                 return $this->respond([
    //                     "status" => "failed",
    //                     "message" => "Le nom de famille est manquant!"
    //                 ]);
    //             }

    //             if ($this->validate(["first_name" => "required"])) {
    //                 if ($this->validate(["first_name" => "min_length[2]"])) {
    //                     $currentUser["first_name"] = $this->request->getPost("first_name");
    //                 } else {
    //                     return $this->respond([
    //                         "status" => "failed",
    //                         "message" => "Le prénom doit contenir au moins deux caractères!"
    //                     ]);
    //                 }
    //             } else {
    //                 return $this->respond([
    //                     "status" => "failed",
    //                     "message" => "Le prénom est manquant!"
    //                 ]);
    //             }

    //             if ($this->validate(["email" => "required"])) {
    //                 if ($this->validate(["email" => "valid_email"])) {
    //                     $currentUser["email"] = $this->request->getPost("email");
    //                     if ($userModel->asArray()->where(["email" => $currentUser["email"]])->first() != [] && $currentUser["email"] != $dataBaseUser["email"]) {
    //                         return $this->respond(["status" => "failed", "message" => "L'adresse mail '" . $currentUser["email"] . "' est déjà utilisé"]);
    //                     }
    //                 } else {
    //                     return $this->respond([
    //                         "status" => "failed",
    //                         "message" => "L'email n'est pas valide!"
    //                     ]);
    //                 }
    //             } else {
    //                 return $this->respond([
    //                     "status" => "failed",
    //                     "message" => "L'email est manquant!"
    //                 ]);
    //             }

    //             if ($this->validate(["sex" => "required"])) {
    //                 if ($this->validate(["sex" => "in_list[Homme,Femme]"])) {
    //                     $currentUser["sex"] = $this->request->getPost("sex");
    //                 } else {
    //                     return $this->respond([
    //                         "status" => "failed",
    //                         "message" => "Le sexe doit être 'Homme' ou 'Femme'!"
    //                     ]);
    //                 }
    //             } else {
    //                 return $this->respond([
    //                     "status" => "failed",
    //                     "message" => "Le sexe est manquant!"
    //                 ]);
    //             }

    //             $currentUser["token"] = $userToken;
    //             $userWaitingModel->save($currentUser, "token = " . $userToken);
    //             return $this->respond([
    //                 "status" => "success",
    //                 "data" => $currentUser
    //             ]);
    //         }
    //     } else {
    //         return $this->respond([
    //             "status" => "failed",
    //             "message" => "Vous devez passer par la méthode '" . $method . "' pour acéder à ce lien"
    //         ]);
    //     }
    // }

    /**
     * Suprime un utilisateur
     *
     * @param string $token
     * @return json
     */
    public function deleteUserWaiting(string $token = null)
    {
        if ($token == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "L'identifiant de l'utilisateur est manquant!"
            ]);
        } else {
            $userWaitingModel = new UserWaitingModel();
            if ($userWaitingModel->find($token) == null) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "L'utilisateur n'est pas inscrit!"
                ]);
            } else {
                $userWaitingModel->delete($token);
                return $this->respond([
                    "status" => "success"
                ]);
            }
        }
    }
}
