<?php

namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Controller;

class News extends Controller
{
    public function index()
    {
        $model = new NewsModel();
        $data = [
            'news' => $model->getNews(),
            'title' => 'News archive',
        ];

        echo view('templates/header', $data);
        echo view("templates/nav", $data);
        echo view('news/overview', $data);
        echo view('templates/footer', $data);
    }
    public function view($slug = null)
    {
        $model = new NewsModel();
        $data['news'] = $model->getNews($slug);
    }
}
