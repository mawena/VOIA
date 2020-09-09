<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Connexion extends controller
{

    public function index()
    {
        $userModel = new UserModel();
        $data = [
            'error' => '',
            'title' => 'Connexion'
        ];

        if ($this->request->getMethod() === 'post' && $this->validate([
            'Identifiant' => 'required|min_length[3]|max_length[255]',
            'Password' => 'required'
        ])) {
            $session = \Config\Services::session();
            $identifiant = $this->request->getPost('Identifiant');
            $password = $this->request->getPost('Password');

            if ($userModel->getUser($identifiant, $password) == UserModel::UNDEFINED_USER) {
                $data['error'] = "L'identifiant n'est pas dans la base de donnée, êtes vous inscrit ?";
            } elseif ($userModel->getUser($identifiant, $password) == UserModel::BAD_PASSWORD) {
                $data['error'] = "Le mot de passe est incorect !";
            } else {
                $currentUser = $userModel->getUser($identifiant, $password);
                $session->set(['currentUser' => $currentUser]);
                return redirect()->to('/');
            }
        }

            echo view('templates/header', $data);
            echo view('templates/nav');
            echo view('pages/connexion', $data);
            echo view('templates/footer');
    }

    public function deconnect()
    {
        $session = \Config\Services::session();
        $session->destroy();
        return redirect()->to("/");
    }
}
