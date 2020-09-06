<?php

namespace App\Controllers;

use App\Models\FormationsModel;
use CodeIgniter\Controller;

class Home extends Controller
{
	protected $table = 'formations';
	public function index()
	{

		$model = new FormationsModel();
		$data['formations'] = $model->getFormation();
		$data = [
			'formations' => $model->getFormation(),
			'title' => 'Home',
		];

		echo view("templates/header", $data);
		echo view("templates/nav", $data);
		echo view("pages/acceuil", $data);
		echo view("templates/footer", $data);
	}

	//--------------------------------------------------------------------

}
