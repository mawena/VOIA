<?php

namespace App\Controllers\FrontEnd;

use App\Libraries\Helper;
use App\Models\TrainingsModel;
use CodeIgniter\Controller;

class HomeController extends Controller
{
	/**
	 * Affiche la page d'acceuil
	 *
	 * @return void
	 */
	public function home()
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

	/**
	 * Affiche une formation
	 *
	 * @param string $slug
	 * @return void
	 */
	public function showTraining(string $slug = null)
	{
		$trainingGroupModel = new TrainingsModel();
		$data = [
			'trainingGroup' => $trainingGroupModel->getTraningGroup($slug)
		];
	}
}
