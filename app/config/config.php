<?php

// DB-Parameter
define('DB_HOST', 'localhost'); // wenn nicht die Standardkonfig von Mamp bei den Ports: 127.0.0.1:8889
define('DB_USER', 'root');
define('DB_PW', 'root');
define('DB_NAME', 'FIT4U');

// zeigt das Verzeichnis an, in dem die Datei liegt. Gibt den vollständigen Pfad an.
// echo __FILE__;

// gibt den Ordner aus, in dem die Datei liegt
// echo dirname(__FILE__);

// Anwendungsweite Konstante definieren, die den Pfad zum Ordner app festhält
define('APPROOT', dirname(dirname(__FILE__)));

// URL, die die Startseite anzeigt, SLASH WEGLASSEN, muss angepasst werden, wenn man die Seite umzieht
define('URLROOT', 'http://localhost:8888');

// Name der Anwendung
define('SITENAME', 'PostBox');

