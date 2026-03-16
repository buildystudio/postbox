<?php
declare(strict_types=1);

namespace App\DTOs;

readonly class UserRegistrationDTO
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $password
    ) {}

    // Factory-Methode: Nimmt das rohe Array nach der Validierung und baut ein sicheres Objekt
    public static function fromArray(array $data): self
    {
        return new self(
            firstName: $data['first_name'],
            lastName: $data['last_name'],
            email: $data['email'],
            password: $data['password']
        );
    }
}