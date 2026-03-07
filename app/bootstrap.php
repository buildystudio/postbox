<?php

// Session starten
session_start();

// Konfiguration laden
require_once 'config/config.php';

// Libraries einbeziehen
// require_once 'libraries/Controller.php';
// require_once 'libraries/Core.php';
// require_once 'libraries/Database.php';

// autoload für den Libraries Ordner
spl_autoload_register(function($className) {
	require_once "libraries/{$className}.php";
});

// helpers einbeziehen
require_once 'helpers/functions.php';

// traits einbeziehen
require_once 'traits/CheckInputAndCsrf.php';