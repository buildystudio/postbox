<?php

/**
 * Kernklasse
 * zerlegt den URL-String und ruft in einem Controller eine Methode auf
 * URL-Format: /controller/method/parameters
 */

class Core
{

	// Eigenschaften
	private $controller = 'Home';
	private $method = 'index';
	private $params = [];

	// Methoden
	public function __construct() {
		// wird automatisch ausgeführt, wenn im Code das Signalwort new kommt
		$url = $this->getURL();
		// beinhalter das Array der URL
		
		// Controller prüfen
		if(isset($url[0])) {
			// prüft, ob Datei existiert
			if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
				$this->controller = ucwords($url[0]); // überschreibt die Eigenschaft controller
				unset($url[0]); // löscht den Eintrag aus dem Array
			}
		}

		// bezieht angeforderten Controller ein. Wird keiner angegeben, wird der oben definierte Default-Wert genutzt
		require_once "../app/controllers/{$this->controller}.php";
		$this->controller = new $this->controller; // macht ein Objekt aus dem String, wegen new wird der constructor ausgeführt

		// Methode prüfen
		if(isset($url[1])) {
			if(method_exists($this->controller, $url[1])) {
				$this->method = $url[1];
				unset($url[1]);
			}
		}

		// Parameter prüfen
		if(isset($url[2])) {
			$this->params = array_values($url); // setzt Index neu, deshalb müssen die Einträge von vorher gelöscht werden	
		}

		// Methode in einem Controller aufrufen, dabei Parameter übergeben
		call_user_func_array([$this->controller, $this->method], $this->params);
	}

	private function getURL() {
		// URL abgreifen und aufbereiten, indem man in zerlegt und in einem Array abspeichert
		
		// leeres Array als Rüchgabevariable anlegen
		
		$url = [];

		// wenn es in der superglobalen $_GET einen Eintrag url gibt, wird etwas ausgeführt
		if(isset($_GET['url'])) {
			// Slash am hinteren Ende entfernen, alles zu Kleinbuchstaben
			$url = rtrim(strtolower($_GET['url']), '');

			// String filtern, nur erlaubte URL-Zeichen
			$url = filter_var($url, FILTER_SANITIZE_URL);

			// in ein Array zerlegen
			$url = explode('/', $url); // der / ist das Zeichen, an dem zerlegt werden soll
		}

		// gibt Wert zurück an den Funktionsaufruf oben
		return $url;
	}
}