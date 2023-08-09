<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\GithubStatistics;

use App\Dto\GithubRepositoriesDto;
use App\Dto\GithubRepositoryDto;
use App\Service\GithubStatistics\Builder\GithubStatisticsBuilderDirector;
use App\Service\GithubStatistics\GithubStatisticsService;
use App\Service\GithubStatistics\Sorter\GithubStatisticsSorter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GithubStatisticsServiceTest extends TestCase
{
    private GithubStatisticsBuilderDirector&MockObject $mockDirector;
    private GithubStatisticsSorter&MockObject $mockSorter;

    private GithubStatisticsService $service;

    protected function setUp(): void
    {
        $this->mockDirector = $this->createMock(GithubStatisticsBuilderDirector::class);
        $this->mockSorter = $this->createMock(GithubStatisticsSorter::class);
        $this->service = new GithubStatisticsService($this->mockDirector, $this->mockSorter);
    }

    public function testForOneRepository(): void
    {
        $repositoryDto1 = $this->createMock(GithubRepositoryDto::class);
        $githubRepositoriesDto = new GithubRepositoriesDto([$repositoryDto1]);

        $this->mockDirector->expects($this->exactly(1))->method('build');
        $this->mockSorter->expects($this->exactly(1))->method('sortByActivity')->willReturn([]);

        $this->service->getStatistics($githubRepositoriesDto);
    }

    public function testForManyRepositories(): void
    {
        $repositoryDto1 = $this->createMock(GithubRepositoryDto::class);
        $repositoryDto2 = $this->createMock(GithubRepositoryDto::class);
        $githubRepositoriesDto = new GithubRepositoriesDto([$repositoryDto1, $repositoryDto2]);

        $this->mockDirector->expects($this->exactly(2))->method('build');
        $this->mockSorter->expects($this->exactly(1))->method('sortByActivity')->willReturn([]);

        $this->service->getStatistics($githubRepositoriesDto);
    }
}
