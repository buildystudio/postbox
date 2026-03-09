<?php
namespace App\Libraries;

use App\Traits\CheckInputAndCsrf;
// Hinweis: Da die Database-Klasse ebenfalls im App\Libraries Namespace liegt,
// müssen wir sie hier nicht extra mit 'use' importieren. Wir können sie direkt nutzen.

/**
 * NACHHER: Der saubere Durchlauferhitzer für Dependency Injection (2026 Enterprise Standard)
 */
class Controller
{
    use CheckInputAndCsrf; 

    // 1. Hier speichern wir die injizierte Datenbank für die Lebensdauer des aktuellen Requests
    protected $db;

    // 2. CONSTRUCTOR INJECTION: Der Base-Controller fängt die DB-Instanz von der Core.php auf!
    public function __construct(Database $db) 
    {
        $this->db = $db;
    }

    public function index()
    {
        // (Kleiner Vorgriff: Falls Redirect später auch in einen Namespace zieht, 
        // musst du es oben mit 'use' importieren. Für jetzt lassen wir es so.)
        Redirect::to(); 
    }

    // lädt Models
    public function model(string $model, $identifier = null) 
    {
        if(file_exists($path = "../app/models/{$model}.php")) require_once $path;
        else die('Basis-Controller: Das ist ein unbekanntes Model');

        // 3. MAGIC HAPPENS HERE: Der Controller reicht die legitime DB-Verbindung 
        // als allererstes Argument an das aufgerufene Model weiter!
        return new $model($this->db, $identifier);
    }

    // lädt Views
    public function view(string $view, array $data = [])
    {
        if(file_exists($path = "../app/views/{$view}.php")) require_once $path;
        else die('Basis-Controller: Das ist ein unbekannter View');
    }   
}