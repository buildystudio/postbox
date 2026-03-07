<?php

/**
	 * Datenbank-Klasse unter Nutzung von PDO
	 * Singleton => Entwurfsmuster
	 * siehe Wikipedia
	 * Methoden, die method chaining unterstützen:
	 *   getInstance()
   *  query()
	 *  get()
   *  delete()
   *  insert()
   *  update()
*/

class Database 
{

	private static $instance = null; // Inhalt verändert sich durch das static nicht, macht die ganze Klasse statisch

	// Zugang zur Datenbank
	private $connect = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
					$user = DB_USER,
					$pw = DB_PW,
					$pdo,
					$query,
					$results;

	// Abfragbare Eigenschaften
	public $error = false,
				 $count = 0;

	// Verbindung zur Datenbank herstellen
	private function __construct() // kann wegen private nicht mehr wie vorher instanziiert werden
	{
		try {
			$this->pdo = new PDO($this->connect, $this->user, $this->pw); // Instanz der PDO-Klasse, die mit den mitgegebenen Parametern versucht, einen Zugang zur Datenbank herzustellen
		}
		// Fehlermeldung
		catch (PDOException $e) {
			die($e->getMessage()); // bricht ab und gibt eine Fehlermeldung aus
		}
	}

	public static function getInstance()
	{
		// self entspricht $this, dieses kann aber bei statischen Methoden nicht verwendet werden. Es wird nur instanziiert, wenn es noch keine Instanz gab. Dadurch gibt es nur einen Zugang zur Datenbank pro URL
		if(!isset(self::$instance)) self::$instance = new self; // :: entspricht ->, hinten ist eine Instanziierung
		return self::$instance;
	}

	 // Datenbank abfragen, Array ist optionaler Parameter
  public function query(string $sql, array $params = [])
  {
    // Fehler-Reset
    $this->error = false;

    // prepared statement
    if($this->query = $this->pdo->prepare($sql)) { // pdo bezieht sich auf die PDO-Instanz, wenn Methode scheitert, gibt es false zurück
      // sind Parameter vorhanden?
      if(count($params)) {
        // für jeden Parameter in $sql: Wert aus $params binden
        foreach($params as $index=>$param) $this->query->bindValue($index+1, $param);
      }

      // DB-Abfrage durchführen
      if($this->query->execute()) { // execute ist eine PHP Methode, wird auf dem prepared Statement durchgeführt
        // Abfrageergebnis speichern
        $this->results = $this->query->fetchAll(PDO::FETCH_OBJ); // speichert alle Ergebnisse in einem Array, das Objekte beinhaltet, in results
        
        // Betroffene Zeilen aktualisieren, zählt die Reihen, die man mit der Abfrage trifft
        $this->count = $this->query->rowCount();
      }
      // Abfrage nicht erfolgreich
      else $this->error = true; // error oben wird wahr gesetzt
    }

    // Beispiel: $db->query('SELECT * FROM useres WHERE id = ? OR gender = ?', [13, 'male']);

    // Instanz zurückgeben für method chaining
    return $this;

    // Method chaining
    // $db->method1()->method2(); damit es funktioniert, muss das Ergebnis von method1 ein Objekt sein
    // das erreicht man mit return $this, dann wird es zu einem Objekt
  }

  // Abfragen oder löschen
  // Beispiel: getOrDelete('GET', 'USERS', ['id', '=', '13'])
  private function getOrDelete(string $action, string $table, array $where=[])
  {
    // prüfen, ob $where-Array aus genau 3 Einträgen besteht, da man das für eine Abfrage braucht
    if(count($where)===3) {
      // zulässige Operatoren für den SQL String
      $operators=['=', '>', '>=', '<', '<=', '<>']; // letztes Symbol bedeutet ungleich
      // $where zerlegen
      $field=$where[0]; // erste Stelle im Array
      $operator=$where[1]; // zweite Stelle im Array
      $value=$where[2]; // dritte Stelle im Array

      // zulässiger Operator?
      if(in_array($operator, $operators)) { // wenn die Information an zweiter Stelle im Array zu den zugelassenen Operatoren gehört
        // Query aufbauen
        $sql="{$action} FROM {$table} WHERE {$field} {$operator} ?";
        // Aufruf von query()
        // falls Methode query() fehlerfrei: Instanz zurückgeben für method chaining
        if(!$this->query($sql, [$value])->error) return $this; // ergibt wieder eine Instant einer Klasse, um wieder eine Methode aufrufen zu können
      }
    }

    // eine Bedingung wird nicht erfüllt oder ein query()-Fehler ist aufgetreten
    return false;
  }

  // Einfügen oder aktualisieren
  private function insertOrUpdate(string $action, string $table, array $fields = [], int $id = -1)
  // die id ist nur für das Update. Für Updates wird immer eine ID benötigt. Wird keine angegeben, dann wird die ID auf -1 gesetzt. Da es diese niemals gibt, wird die Datenbankabfrage abgelehnt. Außerdem macht -1 es optional, wodurch es bei insert() optional ist
  {
  	// folgende Variablen sind für INSERT INTO und UPDATE verfügbar
    if($count = count($fields)) { // zählt die Einträge im assoziativen Array $fields, wenn es leer ist geht es in false und die Abfrage findet nicht statt
      // Schlüssel der Einträge im Array wird in einer Variable gespeichert
      $keys = array_keys($fields);
      // Werteplatzhalter, wird unten im foreach befüllt
      $set = '';

      // wenn INSERT verwendet wird
      if($action === 'INSERT INTO') {
        // für jedes übergebene Feld
        foreach($keys as $index => $key) { // das numerische Array wird durchlaufen
          // Platzhalter zusammensetzen
          if($index == $count-1) $set .= '?';  
          else $set .= '?, ';
          // für jeden Eintrag wird ein ?, (Leerzeichen) geschrieben, bis zum letzten Fall. Dann gibt es nur ein ?. Ergebnis ist (?, ?, ...?). .= bedeutet hinzufügen 
        }

        // query-String aufbauen
        $sql = "{$action} {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$set})";
        // bezieht sich noch auf INSERT INTO
        // implode macht aus einem Array einen String
        // der SQL String hat immer so viele keys wie values als ?
        // ergibt: INSERT INTO posts (`title`, `body`, `created`) VALUES ({$set})
  
      }

      // wenn UPDATE verwendet wird
      else if($action === 'UPDATE') {
        // für jedes übergebene Feld
        foreach($keys as $index => $key) {
          // $set aufbauen inkl. binding, baut Paara aus $key von oben mit ? als Platzhalter für den value
          if($index == $count - 1) $set .= "`{$key}` = ?";
          else $set .= "`{$key}` = ?, ";
        }
        // die($set);  // TEST

        $sql = "{$action} {$table} SET {$set} WHERE id = {$id}";
        // ergibt: UPDATE posts SET `title`=?, `body`=?, `created`=? WHERE id=1
      }

      // andere $action außer UPDATE und INSERT INTO
      else return false;

      // falls Methode query() fehlerfrei: Instanz zurückgeben für method chaining
      if(!$this->query($sql, array_values($fields))->error) return $this;
      // nimmt aus dem assoziativen Array alle Werte und ersetzt damit die ?. Den daraus ergebenen SQL String wird an query() übergeben. Das prüft, ob es einen Fehler gab ($error). Wenn nicht, wird die Abfrage ausgeführt und das Ergebnis der Abfrage kommt in $results
    }

    // eine Bedingung wird nicht erfüllt oder ein query()-Fehler ist aufgetreten
    return false;
  }

  // SQL-SELECT
  public function get(string $table, array $where)
  {
    return $this->getOrDelete('SELECT *', $table, $where);
  }

  // SQL-DELETE
  public function delete(string $table, array $where)
  {
    return $this->getOrDelete('DELETE', $table, $where);
  }

  // SQL-INSERT
  public function insert(string $table, array $fields = [])
  {
    return $this->insertOrUpdate('INSERT INTO', $table, $fields);
  }

  // SQL-UPDATE
  public function update(string $table, int $id, array $fields = [])
  {
    return $this->insertOrUpdate('UPDATE', $table, $fields, $id);
  }

  // Abfrageergebnisse abrufen
	public function results() 
	{
		return $this->results; // getter
	}

	// erstes Abfrageergebnisse abrufen
	public function first()
	{
		return $this->results()[0]; // Array, holt das Objekt an erster Stelle im Array
	}
}