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

    public static function fromArray(array $data, int $userId): self
    {
        return new self(
            title: $data['title'],
            body: $data['body'],
            userId: $userId
        );
    }
}