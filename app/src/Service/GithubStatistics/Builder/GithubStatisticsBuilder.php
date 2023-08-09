<?php

declare(strict_types=1);

namespace App\Service\GithubStatistics\Builder;

use App\Dto\GithubRepositoryDto;
use App\Service\GithubStatistics\Builder\DataProvider\GithubStatisticsStatisticsPullRequestDataProvider;
use App\Service\GithubStatistics\Builder\DataProvider\GithubStatisticsStatisticsReleaseDataProvider;
use App\Service\GithubStatistics\Builder\DataProvider\GithubStatisticsStatisticsRepositoryDataProvider;
use App\Service\GithubStatistics\Model\GithubStatisticsModel;

class GithubStatisticsBuilder implements GithubStatisticsBuilderInterface
{
    /**
     * @var array<string, mixed>
     */
    private array $statistics = [];

    public function __construct(
        private readonly GithubStatisticsStatisticsRepositoryDataProvider $repositoryDataProvider,
        private readonly GithubStatisticsStatisticsPullRequestDataProvider $pullRequestDataProvider,
        private readonly GithubStatisticsStatisticsReleaseDataProvider $releaseDataProvider,
    ) {
    }

    public function buildRepositoryBasicData(GithubRepositoryDto $githubRepositoryDto): self
    {
        $this->statistics = [
            ...$this->statistics,
            ...[
                'userName' => $githubRepositoryDto->getUserName(),
                'repositoryName' => $githubRepositoryDto->getRepositoryName(),
                'url' => sprintf(
                    'https://github.com/%s/%s',
                    $githubRepositoryDto->getUserName(),
                    $githubRepositoryDto->getRepositoryName(),
                ),
            ],
        ];

        return $this;
    }

    public function buildRepositoryStatistics(GithubRepositoryDto $githubRepositoryDto): self
    {
        $this->statistics = [
            ...$this->statistics,
            ...$this->repositoryDataProvider->provide($githubRepositoryDto),
        ];

        return $this;
    }

    public function buildPullRequestStatistics(GithubRepositoryDto $githubRepositoryDto): self
    {
        $this->statistics = [
            ...$this->statistics,
            ...$this->pullRequestDataProvider->provide($githubRepositoryDto),
        ];

        return $this;
    }

    public function buildReleaseStatistics(GithubRepositoryDto $githubRepositoryDto): self
    {
        $this->statistics = [
            ...$this->statistics,
            ...$this->releaseDataProvider->provide($githubRepositoryDto),
        ];

        return $this;
    }

    public function getStatisticsModel(): GithubStatisticsModel
    {
        return new GithubStatisticsModel(
            $this->statistics['userName'],
            $this->statistics['repositoryName'],
            $this->statistics['url'],
            $this->statistics['forks'],
            $this->statistics['stars'],
            $this->statistics['watchers'],
            $this->statistics['lastPullRequestDate'],
            $this->statistics['lastReleaseDate'],
            $this->statistics['lastMergedPullRequestDate'],
            $this->statistics['numberOfClosedPullRequests'],
            $this->statistics['numberOfOpenPullRequests'],
        );
    }
}
