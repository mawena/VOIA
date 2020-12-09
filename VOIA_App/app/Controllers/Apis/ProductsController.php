<?php

namespace App\Controllers\Apis;

use App\Models\ProductsModel;
use CodeIgniter\RESTful\ResourceController;

class ProductsController extends ResourceController
{
    /**
     * Retourne les informations de tout les produits
     *
     * @return json
     */
    public function getAllProduct()
    {
        $currentProductArray = (new ProductsModel())->findAll();
        if ($currentProductArray == []) {
            return $this->respond([
                "status" => "failed",
                "message" => "Il n'y a aucun produit pour le moment!"
            ]);
        } else {
            return $this->respond($currentProductArray);
        }
    }

    /**
     * Retourne les informations d'un produit
     *
     * @param string $token
     * @return json
     */
    public function getProduct(string $token = null)
    {
        $productsModel = new ProductsModel();
        if ($token == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "L'identifiant du produit est manquant!"
            ]);
        } else {
            $currentProduct = $productsModel->find($token);
            if ($currentProduct == null) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le produit demandé n'existe pas!"
                ]);
            } else {
                return $this->respond($currentProduct);
            }
        }
    }

    /**
     * Ajoute un produit à la bdd
     *
     * @return json
     */
    public function storeProduct()
    {
        $productsModel = new ProductsModel();
        if ($this->request->getMethod() == "post") {
            if ($this->validate(["designation" => "required"])) {
                if ($this->validate(["designation" => "min_length[2]"])) {
                    $currentProduct["designation"] = $this->request->getPost("designation");
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "La désignation du produit doit contenir au moins 2 caractères!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "La désignation est manquante!"
                ]);
            }

            if ($this->validate(["description" => "required"])) {
                $currentProduct["description"] = $this->request->getPost("description");
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "La description est manquante!"
                ]);
            }

            if ($this->validate(["price" => "required"])) {
                if ($this->validate(["price" => "is_numeric"])) {
                    $currentProduct["price"] = $this->request->getPost("price");
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le prix du produit doit être un entier!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le prix du produit est manquant!"
                ]);
            }

            $currentProduct["token"] = sha1($currentProduct["designation"] . $currentProduct["price"] . time());
            $currentProduct["logoPath"] = "/Data/default.jpg";
            $productsModel->insert($currentProduct);
            return $this->respond([
                "status" => "success",
                "data" => $currentProduct
            ]);
        } else {
            return $this->respond([
                "status" => "failed",
                "message" => "Vous devez envoyer des informations via un formulaire par 'post'!"
            ]);
        }
    }

    /**
     * Met à jour un produit dans la bdd
     *
     * @param string $token
     * @return json
     */
    public function updateProduct(string $token = null)
    {

        $productsModel = new ProductsModel();
        if ($token == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "L'identifiant du produit est manquant!"
            ]);
        }

        $dataBaseProduct = $productsModel->find($token);
        if ($dataBaseProduct == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "Le produit demandé n'existe pas!"
            ]);
        }

        if ($this->request->getMethod() == "post") {
            if ($this->validate(["designation" => "required"])) {
                if ($this->validate(["designation" => "min_length[2]"])) {
                    $currentProduct["designation"] = $this->request->getPost("designation");
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "La désignation du produit doit contenir au moins 2 caractères!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "La désignation est manquante!"
                ]);
            }

            if ($this->validate(["description" => "required"])) {
                $currentProduct["description"] = $this->request->getPost("description");
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "La description est manquante!"
                ]);
            }

            if ($this->validate(["price" => "required"])) {
                if ($this->validate(["price" => "is_numeric"])) {
                    $currentProduct["price"] = $this->request->getPost("price");
                } else {
                    return $this->respond([
                        "status" => "failed",
                        "message" => "Le prix du produit doit être un entier!"
                    ]);
                }
            } else {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le prix du produit est manquant!"
                ]);
            }
            $currentProduct["logoPath"] = $dataBaseProduct["logoPath"];
            $currentProduct["token"] = $token;
            $productsModel->save($currentProduct, "token=" . $token);
            return $this->respond([
                "status" => "success",
                "data" => $currentProduct
            ]);
        } else {
            return $this->respond([
                "status" => "failed",
                "message" => "Vous devez envoyer des informations via un formulaire par 'post'!"
            ]);
        }
    }

    /**
     * Suprimme un produit de la bdd
     *
     * @param string $token
     * @return json
     */
    public function deleteProduct(string $token = null)
    {
        $productsModel = new ProductsModel();
        if ($token == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "L'identifiant du produit est manquant!"
            ]);
        } else {
            if ($productsModel->find($token) == null) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le produit demandé n'existe pas!"
                ]);
            } else {
                $productsModel->delete($token);
                return $this->respond([
                    "status" => "success"
                ]);
            }
        }
    }
}
