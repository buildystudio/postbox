<?php

class Session 
{

	// prüfen, ob ein Schlüssel in Session existiert
	public static function has(string $key)
	{

		return isset($_SESSION[$key]);

		// Beispiel: Session::has('id');
		// Session wird benötigt, um Code zu verzweigen, je nachdem, ob man eingeloggt ist oder nicht
	}

	// Schlüssel - Wert - Paar setzen und zurückgeben
	public static function put(string $key, $value)
	{

		return $_SESSION[$key] = $value;

		// Beispiel: Session::put('id', 13);
	}

	// Session Wert auslesen
	public static function get(string $key)
	{

		return $_SESSION[$key];

		//Beispiel: Session::get('id');
	}

	// Session Wert löschen
	public static function delete(string $key)
	{
		if(self::has($key)) unset($_SESSION[$key]);
		// self bezieht sich auf die Instanz der Klasse Session. Ersetzt bei einer statischen FUnktion das $this

		//Beispiel: Session::delete('id');
	}

	// Meldungen an den Benutzer ausgeben

	public static function flash(string $key, string $msg = '')
	{

		// Nachricht erstellen
		if(!self::has($key)) self::put($key, $msg);

		// Nachricht auslesen und löschen
		else {
			$message = self::get($key);
			self::delete($key);
			return $message;
		}
	}
}