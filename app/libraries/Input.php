<?php
declare(strict_types=1);

namespace App\Libraries;

class Input 
{
    // prüfen, ob $_GET oder $_POST Werte beinhalten
    public static function exists(string $type = 'post'): bool
    {
        return match ($type) {
            'post' => !empty($_POST),
            'get'  => !empty($_GET),
            default => false,
        };
    }

    // einen Eintrag aus $_GET oder $_POST auslesen
    public static function get(string $item): string
    {
        // FIEO-Standard: Wir speichern die ROHDATEN. Kein htmlentities() mehr beim Input!
        // Wir erzwingen einen String-Cast und entfernen nur führende/abschließende Leerzeichen.
        if (isset($_POST[$item])) {
            return trim((string)$_POST[$item]); 
        } 
        
        if (isset($_GET[$item])) {
            return trim((string)$_GET[$item]);
        }

        // Wert ist nirgendwo vorhanden
        return ''; 
    }
}