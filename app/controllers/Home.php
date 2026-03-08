<?php

namespace App\Controllers;

use App\Libraries\Controller;

class Home extends Controller // Jetzt weiß PHP genau, welcher Controller gemeint ist!
{
    public function index()
    {
        $data = [
            'title' => 'Welcome',
        ];

        $this->view('home/index', $data);
    }
}