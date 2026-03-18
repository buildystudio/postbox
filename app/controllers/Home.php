<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Libraries\Database;
use App\Libraries\Controller;
use App\Attributes\Route;

class Home extends Controller 
{
    #[Route('/', methods: ['GET'])]
    public function index(): void
    {
        $data = ['title' => 'Welcome'];
        $this->view('home/index', $data);
    }
}