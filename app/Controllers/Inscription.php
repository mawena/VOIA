<?php namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Inscription extends Controller{

    public function index(){
        $model = new UserModel();
        $data = [];
        $mawena_code = "uI6UCdk1ruT4NV1";

        if($this->request->getMethod() === 'post' && $this->validate([
            'Identifiant' => 'required|min_length[8]',
            'Password' => 'required|min_length[8]',
            'Last-name' => 'required|min_length[3]',
            'First-name' => 'required|min_length[3]',
            'Mail' => 'required|valid_email',
            'Sex' => 'required'
            ]))
        {
            $tempUser = [
                'identifiant' =>$this->request->getPost('Identifiant'), 
                'password' => password_hash($this->request->getPost('Password'), PASSWORD_DEFAULT),
                'last-name' => $this->request->getPost('Last-name'),
                'first-name' => $this->request->getPost('First-name'),
                'email' => $this->request->getPost('Mail'),
                'sex' => $this->request->getPost('Sex'),
                'code_parainage' => substr(password_hash(\substr($this->request->getPost('Identifiant'), 0, 3) . \substr($this->request->getPost('Last-name'), 0, 3) . \substr($this->request->getPost('Password'), 0, 3), PASSWORD_DEFAULT) ,7, 15)
            ];
            $model->save($tempUser);

        }
            echo view('templates/header', ['title' => 'Inscription']);
            echo view('templates/nav');
            echo view('pages/inscription', ['title' => 'Inscription']);
            echo view('templates/footer');
    }

}