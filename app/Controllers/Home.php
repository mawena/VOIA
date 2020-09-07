<?php

namespace App\Controllers;

use App\Models\TrainingGroupModel;
use App\Models\FormationsModel;
use CodeIgniter\Controller;

class Home extends Controller
{
	public function index()
	{

		$model = new TrainingGroupModel();
		$data = [
			'training_groups' => $model->getTraningGroup(),
			'title' => 'Nos différentes rubriques de cours',
		];
		
		echo view("templates/header", $data);
		echo view("templates/nav", $data);
		echo view("pages/acceuil", $data);
		echo view("templates/footer", $data);
	}

	public function show($slug = null){
		$trainingGroupModel = new TrainingGroupModel();
		$trainingModel = new FormationsModel();

		$data = [
			'trainingGroup' => $trainingGroupModel->getTraningGroup($slug)
		];
	}

	//--------------------------------------------------------------------

}
