<?php namespace App\Controllers;

use App\Models\TrainingModel;
use CodeIgniter\Controller;

class Training extends Controller
{
    protected $table = 'training';
    public function index($test = 1){
        $model = new TrainingModel();

        $data = [
            'training' => $model->getTraining(),
            'title' => 'Cours',
            'currentPage' => 'formations',
        ];

        echo view('templates/header', $data);
        echo view('templates/nav', $data);
        echo view('pages/training', $data);
        echo view('templates/footer', $data);
    }

    public function show($slug = NULL){
        $model = new TrainingModel();

        $data['formation'] = $model->getTraining($slug);
        if(empty($data['formation'])){
            throw new \CodeIgniter\Exceptions\PageNotFoundException('La formation : '. $slug . 'n\'a pas été trouvée');
        }

        $data['title'] = $data['formation']['name'];

        echo view("templates/header", $data);
        echo view("templates/nav", $data);
        echo view("pages/showTraining", $data);
        echo view("templates/footer", $data);
    }

    public function create(){
        $model = new TrainingModel();

        if($this->request->getMethod() === 'post' && $this->validate([
            'name' => 'required|min_length[3]|max_length[255]',
            'duration_month' => 'required',
            'trainers' => 'required',
            'description' => 'required',
            'certified' => 'required',
        ])){
            $model->save([
                'name' => $this->request->getPost('name'),
                'duration_month' => $this->request->getPost('duration_month'),
                'trainers' => $this->request->getPost('trainers'),
                'description' => $this->request->getPost('description'),
                'slug' => url_title($this->request->getPost('name'), '-', TRUE),
                'certified' => $this->request->getPost('certified')
            ]);
            echo view('pages/success');
        }else{
            echo view('templates/header', ['title' => 'Creation d\'un nouveau formulaire']);
            echo view('templates/nav');
            echo view('pages/create');
            echo view('templates/footer');
        }
    }

}