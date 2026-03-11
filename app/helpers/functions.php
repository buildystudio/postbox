<?php
// global verfügbare Funktionen

/**
 * Maskiert Strings sicher für die HTML-Ausgabe (XSS-Schutz)
 * Der 2026 Enterprise Standard: Ersetzt das unsichere Maskieren beim Datenbank-Input.
 */
function e(?string $value): string {
    if ($value === null) {
        return '';
    }
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}