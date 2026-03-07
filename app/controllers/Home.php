<?php

class Home extends Controller // macht Home zu Kindklasse von Controller
{
	
	public function index()
	{


		$data = [
			'title' => 'Welcome',
		];

		$this->view('home/index', $data);
	}
}