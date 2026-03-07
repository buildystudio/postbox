<?php

class Redirect
{
	// Umleitung innerhalb der Anwendung
	
	public static function to(string $location = '') // default Parameter ist die Startseite (mit = '/' eingerichtet)
	{
		header('Location:' . URLROOT . $location); // PHP Funktion
		exit(); // es wird kein weiterer Code ausgeführt
	}
}

// dank static keine Instanziierung
// Redirect::to('user/edit/13'); => localhost/user/edit/13
// Redirect::to(); => zur Homepage umleiten