<?php

namespace App\Controllers;

use App\Models\TrainingsModel;
use CodeIgniter\Controller;

class Home extends Controller
{
	public function index()
	{

		$model = new TrainingsModel();
		$data = [
			'trainings' => $model->getAllTraning(),
			'title' => 'Nos différentes rubriques de cours',
		];
		
		echo view("templates/header", $data);
		echo view("templates/nav", $data);
		echo view("pages/home", $data);
		echo view("templates/footer", $data);
	}

	public function show($slug = null){
		$trainingGroupModel = new TrainingsModel();

		$data = [
			'trainingGroup' => $trainingGroupModel->getTraningGroup($slug)
		];
	}

	//--------------------------------------------------------------------

}
