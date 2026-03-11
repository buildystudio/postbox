<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Libraries\Controller;
use App\DTOs\UserRegistrationDTO;
use App\Libraries\Validator;
use App\Libraries\Input;
use App\Libraries\Session;
use App\Libraries\Redirect;
use Exception;

class Users extends Controller
{
    public function register()
    {
        if($this->checkInputAndCsrf()) {
            $user = $this->model('User');
            $validation = new Validator($this->db);

            $rawData = [
                'first_name' => Input::get('first_name'),
                'last_name'  => Input::get('last_name'),
                'email'      => Input::get('email'),
                'password'   => Input::get('password'),
                'confirm_password' => Input::get('confirm_password'),
            ];

            $validation->check($rawData, [
                'first_name' => ['name' => 'First name', 'required' => true, 'min' => 2, 'max' => 30],
                'last_name'  => ['name' => 'Last name', 'required' => true, 'min' => 2, 'max' => 30],
                'email'      => ['name' => 'Email', 'required' => true, 'unique' => 'users'],
                'password'   => ['name' => 'password', 'required' => true, 'min' => 6],
                'confirm_password' => ['name' => 'confirmation', 'required' => true, 'matches' => 'password'],
            ]); 

            if($validation->passed) {
                try {
                    // DTO aus den validierten Daten bauen
                    $dto = UserRegistrationDTO::fromArray($rawData);
                    
                    // Typsicheres DTO an das Model übergeben
                    $user->create($dto);

                    Session::flash('success', 'You registered successfully. Welcome!');
                    $user->login($dto->email, $rawData['password']);
                    Redirect::to();
                }
                catch(Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $this->view('users/register', $validation->errors);
            }
        } else {
            $this->view('users/register');
        }
    }

    public function login() 
    {
        if($this->checkInputAndCsrf()) { 
            $user = $this->model('User'); 

            foreach($user->loginFields as $key => $value) {
                $user->loginFields[$key] = Input::get($key);
            }

            $validation = new Validator($this->db); // Fix: DB Injection war hier vergessen!
            $validation->check($user->loginFields, [
                'email' => ['name' => 'Email', 'required' => true],
                'password' => ['name' => 'Password', 'required' => true],
            ]);

            if($validation->passed) {
                $user->login($user->loginFields['email'], $user->loginFields['password']);
                if(Session::has('user')) Redirect::to('/posts');
                else die('Login failed!');
            }
            else $this->view('users/login', $validation->errors);

        } else {
            $this->view('users/login');
        }
    }

    public function logout() 
    {
        $this->model('User')->logout();
        Redirect::to(); 
    }

    public function profile()
    {
        if(!Session::has('user')) Redirect::to(); 

        $user = $this->model('User'); 

        if($this->checkInputAndCsrf()) {
            foreach($user->profileFields as $key => $value) {
                $user->profileFields[$key] = Input::get($key);
            }

            $validation = new Validator($this->db);
            $validation->check($user->profileFields, [
                'first_name' => ['name' => 'First name', 'required' => true, 'min' => 2, 'max' => 30],
                'last_name'  => ['name' => 'Last name', 'required' => true, 'min' => 2, 'max' => 30],
            ]);

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
            else $this->view('users/profile', array_merge($validation->errors, ['user' => $user->userData]));
        } else {
            $this->view('users/profile', ['user' => $user->userData]);
        }
    }

    public function password()
    {
        if(!Session::has('user')) Redirect::to();

        if($this->checkInputAndCsrf()) {
            $user = $this->model('User');

            foreach($user->passwordFields as $key => $value) {
                $user->passwordFields[$key] = Input::get($key);
            }

            $validation = new Validator($this->db);
            $validation->check($user->passwordFields, [
                'password_current' => ['name' => 'Current password', 'required' => true],
                'password_new'     => ['name' => 'New password', 'required' => true, 'min' => 6],
                'password_repeat'  => ['name' => 'Repeat password', 'required' => true, 'min' => 6, 'matches' => 'password_new'],
            ]);

            if($validation->passed) {
                if(!password_verify($user->passwordFields['password_current'], $user->userData->password)) {
                    Session::flash('error', 'Your current password is wrong!');
                    Redirect::to('/users/password');
                } else {
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
        } else {
            $this->view('users/password');
        }
    }
}