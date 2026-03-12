<?php
declare(strict_types=1);
namespace App\DTOs;

readonly class PostCreateDTO
{
    public function __construct(
        public string $title,
        public string $body,
        public int $userId
    ) {}
}