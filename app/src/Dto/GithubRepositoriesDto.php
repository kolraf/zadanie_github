<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class GithubRepositoriesDto
{
    /**
     * @param GithubRepositoryDto[] $repositories
     */
    public function __construct(
        #[Assert\Count(min: 1, max: 5)]
        private readonly array $repositories
    ) {
    }

    /**
     * @return GithubRepositoryDto[]
     */
    public function getRepositories(): array
    {
        return $this->repositories;
    }
}
