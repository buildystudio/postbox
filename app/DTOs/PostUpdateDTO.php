<?php
declare(strict_types=1);
namespace App\DTOs;

readonly class PostUpdateDTO
{
    public function __construct(
        public string $title,
        public string $body
    ) {}
}