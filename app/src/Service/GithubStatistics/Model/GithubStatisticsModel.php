<?php

declare(strict_types=1);

namespace App\Service\GithubStatistics\Model;

class GithubStatisticsModel
{
    public function __construct(
        private readonly string $userName,
        private readonly string $repositoryName,
        private readonly string $url,
        private readonly int $forks,
        private readonly int $stars,
        private readonly int $watchers,
        private readonly ?string $lastPullRequestDate,
        private readonly ?string $lastReleaseDate,
        private readonly ?string $lastMergedPullRequestDate,
        private readonly int $numberOfClosedPullRequests,
        private readonly int $numberOfOpenPullRequests
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

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getForks(): int
    {
        return $this->forks;
    }

    public function getStars(): int
    {
        return $this->stars;
    }

    public function getWatchers(): int
    {
        return $this->watchers;
    }

    public function getLastPullRequestDate(): ?string
    {
        return $this->lastPullRequestDate;
    }

    public function getLastReleaseDate(): ?string
    {
        return $this->lastReleaseDate;
    }

    public function getLastMergedPullRequestDate(): ?string
    {
        return $this->lastMergedPullRequestDate;
    }

    public function getNumberOfClosedPullRequests(): int
    {
        return $this->numberOfClosedPullRequests;
    }

    public function getNumberOfOpenPullRequests(): int
    {
        return $this->numberOfOpenPullRequests;
    }
}
