<?php

namespace App\Controllers\FrontEnd;

use App\Models\CoursesModel;
use App\Models\TrainingsModel;
use CodeIgniter\Controller;

class CoursesController extends Controller
{
    public function index()
    {
        $model = new CoursesModel();
        $data = [
            'courses' => $model->getAllCourses(),
            'title' => 'Cours',
            'currentPage' => 'formations',
        ];

        echo view('templates/header', $data);
        echo view('templates/nav', $data);
        echo view('pages/courses', $data);
        echo view('templates/footer', $data);
    }

    public function getCoursesByTrainingGroup($training_group_slug = null)
    {
        $data = [
            'title' => 'Cours',
            'currentPage' => 'formations',
        ];

        $data["currentFormation"] = (new TrainingsModel())->where(["slug" => $training_group_slug])->first()["name"];

        if ($training_group_slug == "communication-digitale") {
            $model = new CoursesModel();
            $data["courses"] = $model->findBy('training_group_slug', $training_group_slug);
        } elseif ($training_group_slug == "perlage") {
            $data["courses"] = "perlage";
        }

        echo view('templates/header', $data);
        echo view('templates/nav', $data);
        echo view('pages/courses', $data);
        echo view('templates/footer', $data);
    }

    public function show($slug = NULL)
    {
        $model = new CoursesModel();
        $data['course_item'] = $model->getCourse($slug);
        if (empty($data['course_item'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Le cours : ' . $slug . 'n\'a pas été trouvée');
        }

        $data['title'] = $data['course_item']['name'];

        echo view("templates/header", $data);
        echo view("templates/nav", $data);
        echo view("pages/showCourse", $data);
        echo view("templates/footer", $data);
    }

    public function search()
    {
        $model = new CoursesModel();

        $data['title'] = 'Aucun résultat';
        if ($this->request->getMethod() === 'post' && $this->validate([
            'formation_search' => 'required'
        ])) {
            $data = [
                'courses' => $model->findBy('name', $this->request->getPost('formation_search')),
                'title' => 'Résutats'
            ];
        }

        echo view("templates/header", $data);
        echo view("templates/nav", $data);
        echo view("pages/courses", $data);
        echo view("templates/footer", $data);
    }


    public function AddCourse()
    {
        $model = new CoursesModel();

        if ($this->request->getMethod() === 'post' && $this->validate([
            'name' => 'required|min_length[3]|max_length[255]',
            'duration_month' => 'required',
            'trainers' => 'required',
            'description' => 'required',
            'certified' => 'required',
        ])) {
            $model->save([
                'name' => $this->request->getPost('name'),
                'duration_month' => $this->request->getPost('duration_month'),
                'trainers' => $this->request->getPost('trainers'),
                'description' => $this->request->getPost('description'),
                'slug' => url_title($this->request->getPost('name'), '-', TRUE),
                'certified' => $this->request->getPost('certified')
            ]);
            echo view('pages/success');
        } else {
            echo view('templates/header', ['title' => 'Creation d\'un nouveau formulaire']);
            echo view('templates/nav');
            echo view('pages/create');
            echo view('templates/footer');
        }
    }
}
