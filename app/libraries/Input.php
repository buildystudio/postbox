<?php

class Input 
{
	// prüfen, ob $_GET oder $_POST Werte beinhalten
	
	public static function exists(string $type = 'post')
	{
		switch ($type) {
			// prüft, ob in $_POST oder $_GET etwas drin steht. Das passiert nur, wenn ein Formular abgeschickt wurde
			case 'post':
					return !empty($_POST) ? true : false; // verkürzte if-Schreibweise
				break;
			case 'get':
					return !empty($_GET) ? true : false; 
				break;
			default:
				return false;
				break;
		}
	}

	// einen Eintrag aus $_GET oder $_POST auslesen
	
	public static function get(string $item)
	{
		if(isset($_POST[$item])) return htmlentities(trim($_POST[$item]), ENT_QUOTES, 'UTF-8'); // prüft, ob ein Feld gefüllt ist, trimmt es und wandelt Sonderzeichen um (schützt den Code). 
		else if(isset($_GET[$item])) return htmlentities(trim($_GET[$item]), ENT_QUOTES, 'UTF-8');
		// Wert ist nirgendwo vorhanden
		return ''; 
	}
}

// Input::get('first_name');