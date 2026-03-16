<?php
declare(strict_types=1);
namespace App\DTOs;

readonly class UserProfileDTO
{
    public function __construct(
        public string $firstName,
        public string $lastName
    ) {}
}