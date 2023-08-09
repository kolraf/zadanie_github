<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dto;

use App\Dto\GithubRepositoryDto;
use PHPUnit\Framework\TestCase;

class GithubRepositoryDtoTest extends TestCase
{
    public function testValues(): void
    {
        $userName = 'userName';
        $repositoryName = 'repositoryName';

        $dto = new GithubRepositoryDto($userName, $repositoryName);

        self::assertSame($dto->getUserName(), $userName);
        self::assertSame($dto->getRepositoryName(), $repositoryName);
    }
}
