<?php

// Session starten
session_start();

// Composer Autoloader einbinden (Ersetzt ab jetzt alle require_once via PSR-4)
require_once __DIR__ . '/../vendor/autoload.php';

// Konfiguration laden
require_once 'config/config.php';

// --- 2026 Facades / Class Aliasing ---
// Erspart uns das manuelle Importieren in dutzenden View-Dateien
class_alias('App\Libraries\Session', 'Session');
class_alias('App\Libraries\Input', 'Input');
class_alias('App\Libraries\CSRF', 'CSRF');
class_alias('App\Libraries\Redirect', 'Redirect');