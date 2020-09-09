<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;


class Dashboard extends Controller
{
    public function index()
    {
        $session = \Config\Services::session();
        $model = new UserModel();
        if ($session->get('currentUser') === NULL) {
            return redirect()->to("/connexion");
        } else {
            $data = [];
            echo view('templates/header.php', $data);
            echo view('templates/nav.php', $data);
            echo view('pages/dashboard.php', $data);
            echo view('templates/footer.php', $data);
        }
    }
}
