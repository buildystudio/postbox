<?php

class Model 
{

	// DB Instanz
	
	protected $db;

	public function __construct()
	{

		// DB Instanz laden
		$this->db = Database::getInstance();
		
	}
}