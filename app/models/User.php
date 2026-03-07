<?php

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


	public function __construct($user = null)
	{

		// ruft den contructor der Elternklasse auf, da dies nicht automatisch passiert
		parent::__construct();

		// prüft, ob ein User angemeldet ist
		if(!$user) {
			if(Session::has($this->sessionKey)) {
				$user = Session::get($this->sessionKey); // holt den Eintrag aus der Session und speichert sie in $user 

				if(!$this->find($user)) $this->logout(); // findet man den key (und damit den Nutzer) nicht auf der Datenbank, wird logout() ausgeführt und der key wird aus der Session entfernt
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