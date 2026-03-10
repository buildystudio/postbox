<?php
namespace App\Controllers;

use App\Libraries\Controller;
use App\Attributes\Route;

class Home extends Controller 
{
    #[Route('/', methods: ['GET'])]
    public function index()
    {
        $data = ['title' => 'Welcome'];
        $this->view('home/index', $data);
    }
}