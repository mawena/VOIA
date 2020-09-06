<?php namespace App\Controllers;

use App\Models\MembreModel;
use CodeIgniter\Controller;

class Connexion extends controller{

    public function index(){
        $model = new MembreModel();
        $data = [];
        if($this->request->getMethod() === 'post' && $this->validate([
            'Identifiant' => 'required|min_length[3]|max_length[255]',
            'Password' => 'required'
            ]))
            {
                $data['currentMembre'] = $model->getMembres($this->request->getPost('Identifiant'), $this->request->getPost('Password'));
                return redirect()->to('/');
            
        }else{
            $data['connexionError'] = "L'identifiant et le mot de passe ne correspondent pas";
            echo view('templates/header', $data);
            // echo view('templates/nav', $data);
            echo view('pages/connexion', $data);
            // echo view('templates/footer', $data);
        }

    }

}