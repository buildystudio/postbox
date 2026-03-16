<?php
namespace App\Libraries;

class Model 
{
    // DB Instanz
    protected $db;

    /**
     * NACHHER: Dependency Injection (Constructor Injection)
     */
    public function __construct(Database $db)
    {
        // Das Model sagt jetzt ganz klar per Type-Hinting: "Ich brauche eine Database-Instanz, um zu funktionieren. Bitte gib sie mir von außen durch die Vordertür!"
        $this->db = $db;
    }
}