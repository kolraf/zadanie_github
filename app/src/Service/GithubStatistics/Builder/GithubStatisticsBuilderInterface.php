<?php

declare(strict_types=1);

namespace App\Service\GithubStatistics\Builder;

use App\Dto\GithubRepositoryDto;
use App\Service\GithubStatistics\Model\GithubStatisticsModel;

interface GithubStatisticsBuilderInterface
{
    public function buildRepositoryBasicData(GithubRepositoryDto $githubRepositoryDto): self;

    public function buildRepositoryStatistics(GithubRepositoryDto $githubRepositoryDto): self;

    public function buildPullRequestStatistics(GithubRepositoryDto $githubRepositoryDto): self;

    public function buildReleaseStatistics(GithubRepositoryDto $githubRepositoryDto): self;

    public function getStatisticsModel(): GithubStatisticsModel;
}
