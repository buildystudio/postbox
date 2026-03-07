<?php

class Users extends Controller
{

	// Registrierung
	public function register()
	{

		// Daten wurden übertragen
		if($this->checkInputAndCsrf()) {

			// Instanz erzeugen
			$user = $this->model('User');

			// Daten aus dem Register in das Model übernehmen, weil das Model eine Datenbankverbindung hat
			foreach($user->registerFields as $key => $value) {
				$user->registerFields[$key] = Input::get($key);
			}

			// Daten validieren
			// Instanz des Validators aufrufen
			$validation = new Validator;
			// Daten sind schon getrimmt und mit htmlentities gesäubert
			// Validierung mit den Regeln für die einzelnen Felder
			$validation->check($user->registerFields, [
					'first_name' => [
							'name' => 'First name',
							'required' => true,
							'min' => 2,
							'max' => 30
					],
					'last_name' => [
							'name' => 'Last name',
							'required' => true,
							'min' => 2,
							'max' => 30
						],
					'email' => [
							'name' => 'Email',
							'required' => true,
							'unique' => 'users'
						],
					'password' => [
							'name' => 'password',
							'required' => true,
							'min' => 6
						],
					'confirm_password' => [
							'name' => 'confirmation',
							'required' => true,
							'matches' => 'password'
						],
				]); 

			// wenn die Validierung erfolgreich ist, werden die Daten in der Datenbank gespeichert
			if($validation->passed) {
				try {
					$user->create([
							'first_name' => $user->registerFields['first_name'],
							'last_name' => $user->registerFields['last_name'],
							'email' => $user->registerFields['email'],
							'password' => password_hash($user->registerFields['password'], PASSWORD_DEFAULT) // Verschlüsselung des Inhalts des Passwort feldes mit bcrypt
						]);

					Session::flash('success', 'You registered successfully. Welcome!');
					
					$user->login($user->registerFields['email'], $user->registerFields['password']);
					
					Redirect::to(); // Leitet zur Startseite weiter
				}
				catch(Exception $e) {
					die($e->getMessage()); // Programm bricht ab und es gibt eine Fehlermeldung
				}
			}

			else $this->view('users/register', $validation->errors);
		}

		// keine Daten übertragen: zeige das leere Formular an
		
		else $this->view('users/register');
	}

	// Login Methode
	public function login() 
	{
		if($this->checkInputAndCsrf()) { // ist etwas im Formular enthalten und den Inhalt des Feldes zum Schutz vor CSRF
			$user = $this->model('User'); // instanziert das User Model

			foreach($user->loginFields as $key => $value) {
				$user->loginFields[$key] = Input::get($key);
			}

			// Daten validieren
			$validation = new Validator;
			$validation->check($user->loginFields, [
					'email' => [
							'name' => 'Email',
							'required' => true
					],
					'password' => [
							'name' => 'Password',
							'required' => true
					],
			]);

			if($validation->passed) {
				$user->login($user->loginFields['email'], $user->loginFields['password']);
				if(Session::has('user')) Redirect::to('/posts');
				else die('Login failed!');
			}
			else $this->view('users/login', $validation->errors);

		} 
		// keine Daten übertragen 
		else $this->view('users/login');
	}

	// Logout Methode
	public function logout() 
	{
		$this->model('User')->logout();; // Instanz User Model
		Redirect::to(); // Weiterleitung auf Startseite
	}

	public function profile()
	{
		if(!Session::has('user')) Redirect::to(); // wenn kein Nutzer angemeldet ist, wird er auf die Startseite umgeleitet

		$user = $this->model('User'); // Instanz des User Models

		if($this->checkInputAndCsrf()) {
			// Abruf der eingegebenen Daten
			foreach($user->profileFields as $key => $value) {
				$user->profileFields[$key] = Input::get($key);
			}

			// Validierung der Daten
			$validation = new Validator;
			$validation->check($user->profileFields, [
					'first_name' => [
							'name' => 'First name',
							'required' => true,
							'min' => 2,
							'max' => 30,
					],
					'last_name' => [
							'name' => 'Last name',
							'required' => true,
							'min' => 2,
							'max' => 30,
					],
			]);

			// wenn die Validierung erfolgreich war
			if($validation->passed) {
				try {
					$user->update($user->profileFields);

					Session::flash('success', 'Profile updated successfully!');
					Redirect::to('/users/profile');
				}
				catch(Exception $e) {
					die($e->getMessage());
				}
			}
			// wenn die Validierung nicht erfolgreich war
			else $this->view('users/profile', array_merge($validation->errors, ['user' => $user->userData]));
		}

		else $this->view('users/profile', ['user' => $user->userData]);
	}

	public function password()
	{
		if(!Session::has('user')) Redirect::to();

		if($this->checkInputAndCsrf()) {

			$user = $this->model('User');

			foreach($user->passwordFields as $key => $value) {
				$user->passwordFields[$key] = Input::get($key);
			}

			$validation = new Validator;
			$validation->check($user->passwordFields, [
					'password_current' => [
							'name' => 'Current password',
							'required' => true,
					],
					'password_new' => [
							'name' => 'New password',
							'required' => true,
							'min' => 6,
					],
					'password_repeat' => [
							'name' => 'Repeat password',
							'required' => true,
							'min' => 6,
							'matches' => 'password_new',
					],
			]);

			if($validation->passed) {
				if(!password_verify($user->passwordFields['password_current'], $user->userData->password)) {
					Session::flash('error', 'Your current password is wrong!');
					Redirect::to('/users/password');
				}
				else {
					try {
						$user->update([
							'password' => password_hash($user->passwordFields['password_new'], PASSWORD_DEFAULT),
						]);
						Session::flash('success', 'Password changed successfully.');
						Redirect::to('/users/password');
					}
					catch(Exception $e) {
						die($e->getMessage());
					}	
				}
			}
			else $this->view('users/password', $validation->errors);
		}

		else $this->view('users/password');
	}
	
}