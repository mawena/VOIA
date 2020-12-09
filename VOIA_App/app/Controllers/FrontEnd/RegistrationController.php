<?php

namespace App\Controllers\FrontEnd;

use App\Models\UserModel;
use CodeIgniter\Controller;

class RegistrationController extends Controller
{

    /**
     * Gère la page d'inscription
     *
     * @param string $parainToken
     * @return void
     */
    public function registration(string $parainToken = null)
    {
        $model = new UserModel();
        $data = [];
        $mawena_code = "uI6UCdk1ruT4NV1";

        if ($parainToken == null) {
            return redirect()->to("/");
        }else{
            
            $response = get_object_vars(json_decode(file_get_contents("http://localhost:85/apis/users/get/" . $parainToken)));
            if(isset($response["status"]) && $response["status"] == "failed"){
                return redirect()->to("/");
            }
        }

        if ($this->request->getMethod() === 'post' && $this->validate([
            'Identifiant' => 'required|min_length[8]',
            'Password' => 'required|min_length[8]',
            'Last-name' => 'required|min_length[3]',
            'First-name' => 'required|min_length[3]',
            'Mail' => 'required|valid_email',
            'Sex' => 'required'
        ])) {
            $tempUser = [
                'identifiant' => $this->request->getPost('Identifiant'),
                'password' => password_hash($this->request->getPost('Password'), PASSWORD_DEFAULT),
                'last-name' => $this->request->getPost('Last-name'),
                'first-name' => $this->request->getPost('First-name'),
                'email' => $this->request->getPost('Mail'),
                'sex' => $this->request->getPost('Sex'),
                'matricule' => substr(password_hash(\substr($this->request->getPost('Identifiant'), 0, 3) . \substr($this->request->getPost('Last-name'), 0, 3) . \substr($this->request->getPost('Password'), 0, 3), PASSWORD_DEFAULT), 7, 15)
            ];
            $model->save($tempUser);
        }
        echo view('templates/header', ['title' => 'Inscription']);
        echo view('templates/nav');
        echo view('pages/inscription', ['title' => 'Inscription']);
        echo view('templates/footer');
    }
}
