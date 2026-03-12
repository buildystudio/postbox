<?php
namespace App\Libraries;

use App\Traits\CheckInputAndCsrf; // Hier sagen wir PHP, wo der Trait wohnt
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

	// lädt Models (Episode 1: PSR-4 Autoloading)
    public function model(string $model) 
    {
        // 1. Wir bauen den kompletten Namespace zusammen
        $modelClass = "\\App\\Models\\" . $model;

        // 2. Wir prüfen über den Composer-Autoloader, ob die Klasse existiert
        if(class_exists($modelClass)) {
            // 3. Model instanziieren
            return new $modelClass();
        }

        die('Basis-Controller: Das ist ein unbekanntes Model: ' . $modelClass);
    }

	// lädt Views
	public function view(string $view, array $data = [])
	{

		// s.o.
		if(file_exists($path = "../app/views/{$view}.php")) require_once $path;
		else die('Basis-Controller: Das ist ein unbekannter View');
	}	
}