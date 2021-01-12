<?php

namespace App\Controllers\FrontEnd;

use Config\Services;
use App\Models\UserModel;
use CodeIgniter\Controller;

class ConnectionController extends Controller
{
    /**
     * Gére la connexion d'un utilisateur
     *
     * @return json
     */
    public function connection()
    {
        $userModel = new UserModel();
        $data = [
            'title' => 'Connexion'
        ];
        $session = Services::session();

        if (isset($_SESSION["currentUser"])) {
            return redirect()->to("/dashboard");
        } else {
            echo view('templates/header', $data);
            echo view('templates/nav');
            echo view('pages/connexionView', $data);
            echo view('templates/footer');
        }
    }

    /**
     * Gère la déconnexion d'un utilisateur
     *
     * @return json
     */
    public function disconnection()
    {
        $session = Services::session();
        $session->destroy();
        return redirect()->to("/");
    }


    /**
     * Gère la recuperation du compte suite à un mot de passe oublié
     *
     * @return json
     */
    public function passwordRecovery()
    {
        $data = [
            'title' => 'Recupérer votre compte'
        ];
        echo view('templates/header', $data);
        echo view('templates/nav');
        echo view('pages/passwordRecoveryView');
        echo view('templates/footer');
    }
}
