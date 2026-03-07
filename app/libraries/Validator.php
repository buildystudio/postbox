<?php

class Validator
{

	// Datenbankzugang
	private $db = null;

	public $passed = false, // Validierung bestanden oder nicht, default ist false
				 $errors = []; // sammelt alle Fehlermeldungen und zeigt sie im view an
				 // später hat man ein assoziatives Array, in dem numerische Arrays (je nachdem, wie viele Fehlermeldungen es sind) enthalten sind
	
	// Datenbankverbindung herstellen
	public function __construct()
	{
		$this->db = Database::getInstance();
	}

	// Funktion zur Validierung
	public function check(array $source, array $items) // $source sind die Daten, $items sind die Prüfregeln
	{
		// jedes zu prüfende Item und die zugehörige Regel wird per foreach durchlaufen
		foreach($items as $item => $rules) {
			// jede dieser einzuhaltenden Regeln 
			foreach($rules as $rule => $detail) {

				// aktuelles Input, der geprüft wird
				$input = $source[$item];

				// WIrd der Wert benötigt?
				if($rule === "required" && empty($input)) {
					$this->addError($item, "{$rules['name']} field is required."); // ein Feld, das benötigt ist, aber leer ist, wird nicht geprüft
				}
				// wenn ein Feld einen EIntrag hat, erfolgt die Prüfung
				else if(!empty($input)) {
					switch ($rule) {
						case 'name':
							// keine Regel, nur Feldbezeichnung
							break;
						case 'min':
							if(strlen($input) < $detail) {
								$this->addError($item, "{$rules['name']} must be a minimum of {$detail} characters.");
							}
							break;
						case 'max':
								if(strlen($input) > $detail) {
								$this->addError($item, "{$rules['name']} must be a maximum of {$detail} characters.");
							}
							break;
						case 'matches':
							if($input !== $source[$detail]) {
								$this->addError($item, "{$rules['name']} field must match {$items[$detail]['name']} field.");
							}
							break;
						case 'unique':
							if($this->db->get($detail, [$item, '=', $input])->count) {
								$this->addError($item, "{$rules['name']} already exists.");
							}
							break;
					}
				}
			}
		}

		if(empty($this->errors)) $this->passed = true; // Einträge im Array $errors werden geprüft. wenn es leer ist, wird $passed auf true gesetzt und die Validierung ist bestanden
	}

	// Fehler zum Array $errors hinzufügen
	private function addError(string $fieldName, string $error) // Name des Feldes, indem der Fehler auftritt, und der Fehlertext
	{
		// wenn noch kein Eintrag in $errors für das aktuelle Feld existiert
		
		if(!isset($this->errors[$fieldName])) $this->errors[$fieldName] = []; // pro Feld ein Array, da es pro Feld mehrere Fehler geben kann. Es entsteht ein mehrdimensionales Array in $errors
		// wenn es noch kein Array gibt, wird für ein Feld ein Array angelegt

		// sonst wird der Fehler in das Array hinzugefügt
		$this->errors[$fieldName][] = $error; // fügt einem existierenden, numerischen Array einen neuen Eintrag hinzu
	}
}