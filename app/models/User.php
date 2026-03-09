<?php
namespace App\Models;

use App\Libraries\Model;
use App\Libraries\Session;
use Exception; // Wichtig für die try-catch Blöcke!
class User extends Model
{

	private $sessionKey = 'user';

	public $userData,
				 $registerFields = [
				 		'first_name' => '',
				 		'last_name' => '',
				 		'email' => '',
				 		'password' => '',
				 		'confirm_password' => '',
				  ],
				  $loginFields = [
				 		'email' => '',
				 		'password' => '',
				 	],
				 	$profileFields = [
						'first_name' => '',
				 		'last_name' => '',
				 	],
				 	$passwordFields = [
				 		'password_current' => '',
				 		'password_new' => '',
				 		'password_repeat' => '',
				 	]; // erwartete Felder, es können keine weiteren Felder von Hackern hinzugefügt werden


	/**
     * NACHHER: Child-Model reicht die DB sauber nach oben
     */
    public function __construct(Database $db, $user = null)
    {
        // CONSTRUCTOR INJECTION: Das Model nimmt die von außen erzeugte DB 
        // entgegen und reicht sie sofort an das Basis-Model weiter!
        parent::__construct($db);

        // Deine restliche Login- und Session-Logik bleibt absolut unverändert
        if(!$user) {
            if(Session::has($this->sessionKey)) {
                $user = Session::get($this->sessionKey); 
                if(!$this->find($user)) $this->logout(); 
            }
        }
        else $this->find($user);
    }

	public function find($identifier = null)
	{

		if($identifier) {
			// prüft ob es numerisch ist. wenn ja, ist es im Feld id, wenn nicht ist es im Feld mail
			$field = is_numeric($identifier) ? 'id' : 'email'; // PHP Funktion

			// DB auslesen
			$data = $this->db->get('users', [$field, '=', $identifier]);


			if($data->count) {
				// Benutzerdaten in der Instanz speichern
				$this->userData = $data->first(); //  nimmt das erste Ergebnis
				return true;
			}
		}

		// es liegt kein $identifier vor
		return false;
	}

	// User registrieren
	public function create(array $fields = [])
	{
		// wenn Daten nicht gespeichert werden können
		if(!$this->db->insert('users', $fields)) {
			throw new Exception('User was not stored in db!');
		}
	}

		// Profil und Passwort ändern
		public function update(array $fields = [], $id = null)
	{
		if(!$id && Session::has($this->sessionKey)) $id = $this->userData->id;

		if(!$this->db->update('users', $id, $fields)) {
			throw new Exception('Update did not work');
		}
	}

		public function login(string $email = '', string $password = '') // Default sind leere Werte. 
	{
		$userExists = $this->find($email); // find() siehe weiter oben! zieht eine Zeile mit allen Daten zum Nutzer anhand der Mail Adresse raus und schreibt es in $userData

		if($userExists && password_verify($password, $this->userData->password)) {
			Session::put($this->sessionKey, $this->userData->id);
			return true;
		}

		return false;
	}

		// Benutzer abmelden
		public function logout()
	{
		Session::delete($this->sessionKey);
	}
}