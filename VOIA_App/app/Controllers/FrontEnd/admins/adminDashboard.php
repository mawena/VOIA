<?php

namespace App\Controllers\admins;

use CodeIgniter\Controller;
use App\Models\UserModel;

class adminDashboard extends Controller{
    public function index(){
        $session = \Config\Services::session();
        $userModel = new UserModel();

        if ($session->get('currentAdmin') === NULL) {
            return redirect()->to("/admin/connexion");
        } else {
            $data['allUsersList'] = $userModel->getAllUsersUnverified();
            $data['title'] = 'Tableau de bord';
            echo view('templates/admins/header.php', $data);
            echo view('templates/admins/nav.php', $data);
            echo view('admins/adminDashboard.php', $data);
            echo view('templates/admins/footer.php', $data);
        }
    }
}