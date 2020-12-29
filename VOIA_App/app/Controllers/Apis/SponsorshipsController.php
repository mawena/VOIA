<?php

namespace App\Controllers\Apis;

use App\Models\SponsorshipsModel;
use CodeIgniter\RESTful\ResourceController;

class SponsorshipsController extends ResourceController
{

    /**
     * Retourne tout les parrainages!
     *
     * @return void
     */
    public function getAllSponsorship()
    {
        $currentSponsorshipArray = (new SponsorshipsModel())->findAll();
        if ($currentSponsorshipArray == []) {
            return $this->respond([
                "status" => "failed",
                "message" => "Il n'y a aucun parrainage pour le moment!"
            ]);
        } else {
            return $this->respond($currentSponsorshipArray);
        }
    }

    /**
     * Retourne un parainage à l'aide de son token
     *
     * @param string $token
     * @return void
     */
    public function getSponsorship(string $token = null)
    {
        if ($token == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "L'identifiant du parrainage est manquant!"
            ]);
        } else {
            $currentSponsorship = (new SponsorshipsModel())->find($token);
            if ($currentSponsorship == null) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le parrainage n'existe pas!"
                ]);
            } else {
                return $this->respond($currentSponsorship);
            }
        }
    }

    /**
     * Retourne les parrainage d'un utilisateur à l'aide de son token
     *
     * @param string $userToken
     * @return void
     */
    public function getgodFatherSponsorship(string $userToken = null)
    {
        if ($userToken == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "L'identifiant du parrain est manquant!"
            ]);
        } else {
            $currentSponsorshipArray = (new SponsorshipsModel())->where(["godFatherToken" => $userToken])->findAll();
            if ($currentSponsorshipArray == null or $currentSponsorshipArray == []) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "L'utilisateur n'a pas encore de fileul"
                ]);
            } else {
                return $this->respond($currentSponsorshipArray);
            }
        }
    }

    /**
     * Ajoute un parainnage dans bdd
     *
     * @return void
     */
    public function storeSponsorship()
    {
        if ($this->request->getPost("post")) {
            echo "inscription ... en cours de création";
        } else {
            return $this->respond([
                "status" => "failed",
                "message" => "Seul un formulaire envoyé par 'post' est autorisé pour cette adresse!"
            ]);
        }
    }

    /**
     * Met à jour un parainnage dans la bdd
     *
     * @param string $token
     * @return void
     */
    public function updateSponsorship(string $token = null)
    {
        if ($token == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "L'identifiant du parrainage est manquant!"
            ]);
        } else {
            echo "update...en cours de création";
        }
    }

    /**
     * Suprimme un parainage de la bdd
     *
     * @param string $token
     * @return void
     */
    public function deleteSponsorship(string $token = null)
    {
        $sponsorshipModel = new SponsorshipsModel();
        if ($token == null) {
            return $this->respond([
                "status" => "failed",
                "message" => "L'identifiant du parrainage est manquant!"
            ]);
        } else {
            if ($sponsorshipModel->find($token) == null) {
                return $this->respond([
                    "status" => "failed",
                    "message" => "Le parainnage n'existe pas!"
                ]);
            } else {
                $sponsorshipModel->delete($token);
                return $this->respond([
                    "status" => "success"
                ]);
            }
        }
    }
}
