<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dto;

use App\Dto\GithubRepositoriesDto;
use App\Dto\GithubRepositoryDto;
use PHPUnit\Framework\TestCase;

class GithubRepositoriesDtoTest extends TestCase
{
    public function testValues(): void
    {
        $dto1 = new GithubRepositoryDto('userName1', 'repositoryName1');
        $dto2 = new GithubRepositoryDto('userName2', 'repositoryName2');

        $repositoriesDto = new GithubRepositoriesDto([$dto1, $dto2]);
        $repositories = $repositoriesDto->getRepositories();

        self::assertCount(2, $repositories);
        self::assertSame($dto1, $repositories[0]);
        self::assertSame($dto2, $repositories[1]);
    }
}
