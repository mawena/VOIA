<?php

namespace App\Controllers\Apis;

use App\Models\ProductsModel;
use App\Models\PackagesModel;
use CodeIgniter\Pager\Pager;
use CodeIgniter\RESTful\ResourceController;


class PackagesController extends ResourceController
{

    /**
     * Retourne les informations d'un package
     *
     * @param string $token
     * @return json
     */
    public function getPackage(string $token = null)
    {
        if ($token == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "L'indentifiant du package est manquant!"
            ]);
        } else {
            $packageModel = new PackagesModel();
            $currentPackage = $packageModel->find($token);
            if ($currentPackage == null) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le package demandé n'est pas inscrit!"
                ]);
            } else {
                $currentPackage["product"] = (new ProductsModel())->find($currentPackage["productToken"]);
                return $this->respond($currentPackage);
            }
        }
    }

    /**
     * Retourne Tous les packages ou tous les packages d'un produit
     *
     * @param string $productToken
     * @return json
     */
    public function getAllPackage(string $productToken = null)
    {
        $packageModel = new PackagesModel();
        $productModel = new ProductsModel();
        if ($productToken == null) {
            $currentPackagesArray = $packageModel->findAll();
        } else {
            $currentPackagesArray = $packageModel->asArray()->where(["productToken", $productToken])->findAll();
        }

        if ($currentPackagesArray == [] || $currentPackagesArray == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "Il n'y a aucun package pour le moment!"
            ]);
        } else {
            foreach ($currentPackagesArray as $key => $currentPackage) {
                $currentPackagesArray[$key]["product"] = $productModel->find($currentPackage["productToken"]);
            }
            return $this->respond($currentPackagesArray);
        }
    }

    public function storePackage()
    {
        helper("text");
        date_default_timezone_set('UTC');
        if ($this->request->getMethod() == "post") {
            if ($this->validate(["productToken" => "required"])) {
                $currentPackage["productToken"] = $this->request->getPost("productToken");
                $currentPackage["product"] = (new ProductsModel())->find($currentPackage["productToken"]);
                if ($currentPackage["product"] == null) {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le produit n'existe pas!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "L'identifiant du package est manquant!"
                ]);
            }

            if ($this->validate(["designation" => "required"])) {
                if ($this->validate(["designation" => "min_length[2]"])) {
                    $currentPackage["designation"] = $this->request->getPost("designation");
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "La désignation doit contenir au moins 2 caractères!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "La désignation est manquante!"
                ]);
            }

            if ($this->validate(["description" => "required"])) {
                if ($this->validate(["description" => "min_length[2]"])) {
                    $currentPackage["description"] = $this->request->getPost("description");
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "La description doit contenir au moins 2 caractères!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "La description est manquante!"
                ]);
            }

            if ($this->validate(["numberPerson" => "required"])) {
                if ($this->validate(["numberPerson" => "is_numeric"])) {
                    $currentPackage["numberPerson"] = $this->request->getPost("numberPerson");
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le nombre de personne à parainer doit être un nombre!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le nombre de personne à parainé est manquant!"
                ]);
            }

            if ($this->validate(["timeOut" => "required"])) {
                if ($this->validate(["timeOut" => "is_numeric"])) {
                    $currentPackage["timeOut"] = $this->request->getPost("timeOut");
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "La durée du package doit être un entier de type 'timestamp'!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "La durée du package est manquant!"
                ]);
            }

            if ($this->validate(["price" => "required"])) {
                if ($this->validate(["price" => "is_numeric"])) {
                    $currentPackage["price"] = $this->request->getPost("price");
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le prix doit être un entier!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le prix est manquant!"
                ]);
            }

            $currentPackage["slug"] = url_title($currentPackage["designation"]);
            $currentPackage["token"] = sha1($currentPackage["designation"] . $currentPackage["timeOut"] . time());
            $currentPackage["logoPath"] = "/Data/default.jpg";
            (new PackagesModel())->insert($currentPackage);
            return $this->respond([
                "status" => "success",
                "data" => $currentPackage
            ]);
        } else {
            return $this->respond([
                "status" => "failed",
                "message" => "Vous devez envoyez des données via un formulaire 'post'!"
            ]);
        }
    }
    public function updatePackage(string $token = null)
    {
        date_default_timezone_set('UTC');
        $packageModel = new PackagesModel();
        if ($this->request->getMethod() == "post") {
            if ($token == null) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "L'identifiant du package est manquant!"
                ]);
            }

            $dataBasePackage = $packageModel->find($token);
            if ($dataBasePackage == null) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le package n'existe pas!"
                ]);
            }

            if ($this->validate(["productToken" => "required"])) {
                $currentPackage["productToken"] = $this->request->getPost("productToken");
                $currentPackage["product"] = (new ProductsModel())->find($currentPackage["productToken"]);
                if ($currentPackage["product"] == null) {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le produit n'existe pas!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "L'identifiant du package est manquant!"
                ]);
            }

            if ($this->validate(["designation" => "required"])) {
                if ($this->validate(["designation" => "min_length[2]"])) {
                    $currentPackage["designation"] = $this->request->getPost("designation");
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "La désignation doit contenir au moins 2 caractères!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "La désignation est manquante!"
                ]);
            }

            if ($this->validate(["description" => "required"])) {
                if ($this->validate(["description" => "min_length[2]"])) {
                    $currentPackage["description"] = $this->request->getPost("description");
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "La description doit contenir au moins 2 caractères!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "La description est manquante!"
                ]);
            }

            if ($this->validate(["numberPerson" => "required"])) {
                if ($this->validate(["numberPerson" => "is_numeric"])) {
                    $currentPackage["numberPerson"] = $this->request->getPost("numberPerson");
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le nombre de personne à parainer doit être un nombre!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le nombre de personne à parainé est manquant!"
                ]);
            }

            if ($this->validate(["timeOut" => "required"])) {
                if ($this->validate(["timeOut" => "is_numeric"])) {
                    $currentPackage["timeOut"] = $this->request->getPost("timeOut");
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "La durée du package doit être un entier de type 'timestamp'!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "La durée du package est manquant!"
                ]);
            }

            if ($this->validate(["price" => "required"])) {
                if ($this->validate(["price" => "is_numeric"])) {
                    $currentPackage["price"] = $this->request->getPost("price");
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le prix doit être un entier!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le prix est manquant!"
                ]);
            }

            $currentPackage["logoPath"] = $dataBasePackage["logoPath"];
            $packageModel->save($currentPackage, "token = " . $token);
            return $this->respond([
                "status" => "success",
                "data" => $currentPackage
            ]);
        } else {
            return $this->respond([
                "status" => "failed",
                "message" => "Vous devez envoyez des données via un formulaire 'post'!"
            ]);
        }
    }

    /**
     * Suprime un package de la base de données
     *
     * @param string $token
     * @return json
     */
    public function deletePackage(string $token = null)
    {
        $packageModel = new PackagesModel();
        if ($token == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "L'identifant"
            ]);
        } else {
            if ($packageModel->find($token) == null) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le package n'existe pas!"
                ]);
            } else {
                $packageModel->delete($token);
                return $this->respond([
                    "status" => "success"
                ]);
            }
        }
    }
}
