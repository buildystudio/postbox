<?php
declare(strict_types=1);

namespace App\Libraries;

class Validator
{
    public bool $passed = false;
    public array $errors = [];
    
    // 2026 Standard: Constructor Property Promotion
    public function __construct(private Database $db) {}

    public function check(array $source, array $items): void
    {
        foreach ($items as $item => $rules) {
            $input = (string)($source[$item] ?? '');
            $fieldName = $rules['name'] ?? $item;

            // 1. Guard Clause für 'required' (beendet die Prüfung für dieses Feld vorzeitig, wenn leer)
            if (!empty($rules['required']) && empty($input)) {
                $this->addError($item, "{$fieldName} field is required.");
                continue; 
            }

            // 2. Wenn es Input gibt, jagen wir ihn durch die restlichen Regeln
            if (!empty($input)) {
                foreach ($rules as $rule => $ruleValue) {
                    // Metadaten überspringen
                    if ($rule === 'name' || $rule === 'required') {
                        continue;
                    }

                    // 3. MAGIC HAPPENS HERE: PHP 8 Match Expression!
                    // Es gibt einen String (Fehler) zurück oder null (Erfolg)
                    $error = match ($rule) {
                        'min'     => $this->validateMin($input, (int)$ruleValue) ? null : "{$fieldName} must be a minimum of {$ruleValue} characters.",
                        'max'     => $this->validateMax($input, (int)$ruleValue) ? null : "{$fieldName} must be a maximum of {$ruleValue} characters.",
                        'matches' => $this->validateMatches($input, (string)$source[$ruleValue]) ? null : "{$fieldName} field must match {$items[$ruleValue]['name']} field.",
                        'unique'  => $this->validateUnique($input, (string)$ruleValue, $item) ? null : "{$fieldName} already exists.",
                        default   => null,
                    };

                    // Wenn die Match-Expression einen Fehler geworfen hat, speichern wir ihn
                    if ($error) {
                        $this->addError($item, $error);
                    }
                }
            }
        }

        $this->passed = empty($this->errors);
    }

    // --- Isolierte, testbare Validierungs-Methoden (Single Responsibility Principle) ---

    private function validateMin(string $input, int $min): bool {
        return strlen($input) >= $min;
    }

    private function validateMax(string $input, int $max): bool {
        return strlen($input) <= $max;
    }

    private function validateMatches(string $input, string $matchAgainst): bool {
        return $input === $matchAgainst;
    }

    private function validateUnique(string $input, string $table, string $column): bool {
        return $this->db->get($table, [$column, '=', $input])->count === 0;
    }

    // -----------------------------------------------------------------------------------

    private function addError(string $fieldName, string $error): void
    {
        if (!isset($this->errors[$fieldName])) {
            $this->errors[$fieldName] = [];
        }
        $this->errors[$fieldName][] = $error;
    }
}