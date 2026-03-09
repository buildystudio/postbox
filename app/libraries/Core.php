<?php

namespace App\Libraries;

/**
 * App Core Class (Front Controller / Router)
 * * Diese Klasse fungiert als rudimentärer Router für das Legacy-Framework.
 * Sie parst die eingehende URL und delegiert den Request an den entsprechenden Controller.
 * URL-Format: /controller/method/parameters
 */
class Core
{
    // Default-Routing-Konfiguration
    private $controller = 'Home';
    private $method = 'index';
    private $params = [];

    public function __construct() 
    {
        // 1. Request-URL extrahieren und parsen
        $url = $this->getURL();
        
        // 2. Controller evaluieren
        if(isset($url[0])) {
            // Controller-Namen formatieren (z.B. 'posts' -> 'Posts')
            $requestedController = ucwords($url[0]);
            
            // Prüfen, ob der Controller existiert 
            // Wichtig: Achte darauf, dass dein Ordner jetzt 'Controllers' heißt (PSR-4 Case Sensitivity)
            if(file_exists('../app/Controllers/' . $requestedController . '.php')) {
                $this->controller = $requestedController;
                unset($url[0]);
            }
        }

   /**
 * NACHHER: Die Composition Root (Der Geburtsort der Abhängigkeiten)
 */
// 3. Controller dynamisch instanziieren (Die PSR-4 Magie)
// Wir bauen den Fully Qualified Class Name (FQCN) zusammen.
$controllerClass = '\\App\\Controllers\\' . $this->controller;

// 1. Wir erschaffen die Datenbankverbindung EIN einziges Mal für den gesamten Request!
$db = new \App\Libraries\Database();

// 2. Wir übergeben (injizieren) die Datenbank durch die Vordertür an den Controller!
// Composer lädt die Klasse, und wir füttern den Konstruktor direkt mit der Abhängigkeit.
$this->controller = new $controllerClass($db);

        // 4. Methode auf dem Controller evaluieren
        if(isset($url[1])) {
            if(method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // 5. Parameter extrahieren
        if(isset($url[2])) {
            // Array re-indexieren, da Controller und Methode mit unset() entfernt wurden
            $this->params = array_values($url);  
        }

        // 6. Methode aufrufen und Parameter übergeben
        // Modernes PHP 8+ Feature: Argument Unpacking (Spread Operator) statt call_user_func_array
        $this->controller->{$this->method}(...$this->params);
    }
/**
     * Extrahiert die URL direkt aus dem Server-Request (2026 Standard)
     * Keine .htaccess Hacks mit $_GET['url'] mehr nötig!
     **/
    private function getURL() 
    {
        $url = [];

        // Wir lesen die aufgerufene Route direkt aus dem Server aus
        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        
        // Falls GET-Parameter wie ?id=1 dranhängen, schneiden wir die für das saubere Routing ab
        $requestUri = explode('?', $requestUri)[0];

        // Schrägstriche vorne und hinten sauber entfernen
        $path = trim($requestUri, '/');

        if(!empty($path)) {
            // Security: Nur valide URL-Zeichen zulassen
            $path = filter_var($path, FILTER_SANITIZE_URL);
            
            // URL in verwertbare Segmente zerlegen
            $url = explode('/', $path); 
        }

        return $url;
    }
	}