<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Attributes\Route;
use App\Libraries\Controller;
use App\Libraries\Validator;
use App\Libraries\Input;
use App\Libraries\Session;
use App\Libraries\Redirect;
use App\DTOs\UserRegistrationDTO;
use App\DTOs\UserLoginDTO;
use App\DTOs\UserProfileDTO;
use App\DTOs\UserPasswordDTO;
use Exception;

class Users extends Controller
{
    #[Route('/users/register', methods: ['GET', 'POST'])]
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
                    $dto = UserRegistrationDTO::fromArray($rawData);
                    $user->create($dto);

                    Session::flash('success', 'You registered successfully. Welcome!');
                    
                    // FIX: Das Login-Model erwartet jetzt strikt ein DTO!
                    $loginDto = new UserLoginDTO($dto->email, $rawData['password']);
                    $user->login($loginDto);
                    
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

    #[Route('/users/login', methods: ['GET', 'POST'])]
    public function login() 
    {
        if($this->checkInputAndCsrf()) { 
            $user = $this->model('User'); 
            
            $rawData = [
                'email' => Input::get('email'),
                'password' => Input::get('password')
            ];

            $validation = new Validator($this->db);
            $validation->check($rawData, [
                'email' => ['name' => 'Email', 'required' => true],
                'password' => ['name' => 'Password', 'required' => true],
            ]);

            if($validation->passed) {
                $dto = new UserLoginDTO($rawData['email'], $rawData['password']);
                
                if($user->login($dto)) Redirect::to('/posts');
                else die('Login failed!'); 
            }
            else $this->view('users/login', $validation->errors);

        } else {
            $this->view('users/login');
        }
    }
    
    #[Route('/users/logout', methods: ['GET'])]
    public function logout() 
    {
        $this->model('User')->logout();
        Redirect::to(); 
    }

    #[Route('/users/profile', methods: ['GET', 'POST'])]
    public function profile()
    {
        if(!Session::has('user')) Redirect::to(); 

        $user = $this->model('User'); 

        if($this->checkInputAndCsrf()) {
            // FIX: Sauberes Array statt $user->profileFields Iteration
            $rawData = [
                'first_name' => Input::get('first_name'),
                'last_name'  => Input::get('last_name')
            ];

            $validation = new Validator($this->db);
            $validation->check($rawData, [
                'first_name' => ['name' => 'First name', 'required' => true, 'min' => 2, 'max' => 30],
                'last_name'  => ['name' => 'Last name', 'required' => true, 'min' => 2, 'max' => 30],
            ]);

            if($validation->passed) {
                try {
                    // FIX: Typsicheres Profil-DTO an das Model übergeben
                    $dto = new UserProfileDTO($rawData['first_name'], $rawData['last_name']);
                    $user->update($dto);
                    
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

    #[Route('/users/password', methods: ['GET', 'POST'])]
    public function password()
    {
        if(!Session::has('user')) Redirect::to();

        if($this->checkInputAndCsrf()) {
            $user = $this->model('User');

            // FIX: Sauberes Array statt $user->passwordFields Iteration
            $rawData = [
                'password_current' => Input::get('password_current'),
                'password_new'     => Input::get('password_new'),
                'password_repeat'  => Input::get('password_repeat')
            ];

            $validation = new Validator($this->db);
            $validation->check($rawData, [
                'password_current' => ['name' => 'Current password', 'required' => true],
                'password_new'     => ['name' => 'New password', 'required' => true, 'min' => 6],
                'password_repeat'  => ['name' => 'Repeat password', 'required' => true, 'min' => 6, 'matches' => 'password_new'],
            ]);

            if($validation->passed) {
                if(!password_verify($rawData['password_current'], $user->userData->password)) {
                    Session::flash('error', 'Your current password is wrong!');
                    Redirect::to('/users/password');
                } else {
                    try {
                        // FIX: Typsicheres Passwort-DTO an das Model übergeben
                        $dto = new UserPasswordDTO($rawData['password_current'], $rawData['password_new']);
                        $user->update($dto);
                        
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