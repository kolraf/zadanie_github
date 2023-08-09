<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\GithubStatistics\Builder;

use App\Dto\GithubRepositoryDto;
use App\Service\GithubStatistics\Builder\GithubStatisticsBuilderDirector;
use App\Service\GithubStatistics\Builder\GithubStatisticsBuilderInterface;
use App\Service\GithubStatistics\Model\GithubStatisticsModel;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GithubStatisticsBuilderDirectorTest extends TestCase
{
    private GithubStatisticsBuilderInterface&MockObject $mockBuilder;

    private GithubStatisticsBuilderDirector $director;

    public function setUp(): void
    {
        $this->mockBuilder = $this->createMock(GithubStatisticsBuilderInterface::class);
        $this->director = new GithubStatisticsBuilderDirector($this->mockBuilder);
    }

    public function testBuild(): void
    {
        $mockGithubRepositoryDto = $this->createMock(GithubRepositoryDto::class);
        $mockStatisticsModel = $this->createMock(GithubStatisticsModel::class);

        $this->mockBuilder
            ->expects($this->exactly(1))
            ->method('buildRepositoryBasicData')
            ->willReturn($this->mockBuilder);
        $this->mockBuilder
            ->expects($this->exactly(1))
            ->method('buildRepositoryStatistics')
            ->willReturn($this->mockBuilder);
        $this->mockBuilder
            ->expects($this->exactly(1))
            ->method('buildPullRequestStatistics')
            ->willReturn($this->mockBuilder);
        $this->mockBuilder
            ->expects($this->exactly(1))
            ->method('buildReleaseStatistics')
            ->willReturn($this->mockBuilder);
        $this->mockBuilder->expects($this->exactly(1))->method('getStatisticsModel')
            ->willReturn($mockStatisticsModel);

        self::assertSame($mockStatisticsModel, $this->director->build($mockGithubRepositoryDto));
    }
}
