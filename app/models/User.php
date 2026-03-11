<?php
declare(strict_types=1);

namespace App\Models;
use App\Libraries\Database;
use App\Libraries\Model;
use App\DTOs\UserRegistrationDTO;
use App\Libraries\Session;
use Exception;

class User extends Model
{
    private string $sessionKey = 'user';

    public $userData;
    
    // registerFields ist komplett gelöscht (wird jetzt durch DTO gelöst!)
    // Die anderen Arrays bleiben vorerst für Episode 5+ erhalten, aber mit korrekter Syntax:
    public array $loginFields = [
        'email' => '',
        'password' => '',
    ];
    public array $profileFields = [
        'first_name' => '',
        'last_name' => '',
    ];
    public array $passwordFields = [
        'password_current' => '',
        'password_new' => '',
        'password_repeat' => '',
    ];

  // Der 2026 Enterprise Way: DB per DI erzwingen
    public function __construct(Database $db, $user = null)
    {
        // 1. Die DB an das Basis-Model weiterreichen!
        parent::__construct($db);

        // 2. Deine alte Logik für die Session
        if(!$user) {
            if(Session::has($this->sessionKey)) {
                $user = Session::get($this->sessionKey);
                if(!$this->find($user)) $this->logout(); 
            }
        } else {
            $this->find($user);
        }
    }

    public function find($identifier = null)
    {
        if($identifier) {
            $field = is_numeric($identifier) ? 'id' : 'email';
            $data = $this->db->get('users', [$field, '=', $identifier]);

            if($data->count) {
                $this->userData = $data->first(); 
                return true;
            }
        }
        return false;
    }

    // 2026 Enterprise Way: Typsicheres DTO statt Array
    public function create(UserRegistrationDTO $dto): void
    {
        $fields = [
            'first_name' => $dto->firstName,
            'last_name'  => $dto->lastName,
            'email'      => $dto->email,
            'password'   => password_hash($dto->password, PASSWORD_DEFAULT) 
        ];

        if(!$this->db->insert('users', $fields)) {
            throw new Exception('User was not stored in db!');
        }
    }

    public function update(array $fields = [], $id = null)
    {
        if(!$id && Session::has($this->sessionKey)) $id = $this->userData->id;

        if(!$this->db->update('users', $id, $fields)) {
            throw new Exception('Update did not work');
        }
    }

    public function login(string $email = '', string $password = '') 
    {
        $userExists = $this->find($email); 

        if($userExists && password_verify($password, $this->userData->password)) {
            Session::put($this->sessionKey, $this->userData->id);
            return true;
        }

        return false;
    }

    public function logout()
    {
        Session::delete($this->sessionKey);
    }
}