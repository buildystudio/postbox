<?php
declare(strict_types=1);
namespace App\DTOs;

readonly class UserPasswordDTO
{
    public function __construct(
        public string $passwordCurrent,
        public string $passwordNew
    ) {}
}