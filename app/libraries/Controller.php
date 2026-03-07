<?php

/**
 * Basis-Controller (Eltern-Klasse)
 * Lädt Models und Views
 */

class Controller
{

	// trait einbinden
	
	use CheckInputAndCsrf; // allen Controllern ist diese Methode bekannt

	// hat die Kindcontroller Klasse keinen Index, wird diese genutzt. In den Kindcontroller kann man trotzdem eine Index-Methode schreiben, Die im Kindcontroller würde diese hier überschreiben
	public function index()
	{
		Redirect::to(); // bringt zurück zur Startseite, wenn eine Seite nicht existiert, die man aufrufen will
	}

	// lädt Models
	public function model(string $model, $identifier = null) 
	{

		//prüft, ob eine Datei existiert und speichert sie direkt in eine Variable. Bindet die Datei ein.
		if(file_exists($path = "../app/models/{$model}.php")) require_once $path;
		else die('Basis-Controller: Das ist ein unbekanntes Model');

		// es wird eine Instanz erstellt aus der Datei Model.php und übergibt einen Parameter, der im constructor landet. Gibt Wert dorthin zurück, wo die Methode model aufgerufen wird
		return new $model($identifier);
	}

	// lädt Views
	public function view(string $view, array $data = [])
	{

		// s.o.
		if(file_exists($path = "../app/views/{$view}.php")) require_once $path;
		else die('Basis-Controller: Das ist ein unbekannter View');
	}	
}