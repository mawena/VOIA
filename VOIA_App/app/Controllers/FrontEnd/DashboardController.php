<?php

namespace App\Controllers\FrontEnd;

use App\Models\UserModel;
use CodeIgniter\Controller;


class DashboardController extends Controller
{
    public function dashboard()
    {
        $session = \Config\Services::session();
        $model = new UserModel();
        // if (isset($_SESSION['currentUser'])) {
            $data["title"] = ["Tableau de bord"];
            echo view('templates/header.php', $data);
            echo view('templates/nav.php', $data);
            echo view('pages/dashboard.php', $data);
            echo view('templates/footer.php', $data);
        // } else {
        //     return redirect()->to("/connexion");
        // }
    }
}
