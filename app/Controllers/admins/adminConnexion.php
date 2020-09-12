<?php

namespace App\Controllers\admins;

use App\Models\admins\AdminModel;
use CodeIgniter\Controller;

class adminConnexion extends Controller
{
    public function connect()
    {
        $adminModel = new AdminModel();

        $data = [
            'error' => '',
            'title' => 'Connexion Admin'
        ];

        if ($this->request->getMethod() === 'post' && $this->validate([
            'Identifiant' => 'required|min_length[3]|max_length[255]',
            'Password' => 'required'
        ])) {
            $session = \Config\Services::session();
            $identifiant = $this->request->getPost('Identifiant');
            $password = $this->request->getPost('Password');

            if ($adminModel->getAdmin($identifiant, $password) == AdminModel::UNDEFINED_USER) {
                $data['error'] = "L'identifiant n'est pas dans la base de donnée, êtes vous inscrit ?";
            } elseif ($adminModel->getAdmin($identifiant, $password) == AdminModel::BAD_PASSWORD) {
                $data['error'] = "Le mot de passe est incorect !";
            } else {
                $session->set(['currentAdmin' => $adminModel->getAdmin($identifiant, $password)]);
                return redirect()->to('/admin');
            }
        }

        echo view("templates/admins/header", $data);
        echo view("templates/admins/nav", $data);
        echo view("admins/adminConnexion", $data);
        echo view("templates/admins/footer", $data);
    }

    public function deconnect()
    {
        $session = \Config\Services::session();
        $session->destroy();
        return redirect()->to("/admin");
    }
}
