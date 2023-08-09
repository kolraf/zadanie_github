<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class GithubRepositoryDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Nazwa użytkownika jest wymagana.')]
        private readonly string $userName,
        #[Assert\NotBlank(message: 'Nazwa repozytorium jest wymagana.')]
        private readonly string $repositoryName,
    ) {
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getRepositoryName(): string
    {
        return $this->repositoryName;
    }
}
