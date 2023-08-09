<?php

declare(strict_types=1);

namespace App\Service\GithubStatistics\Builder;

use App\Dto\GithubRepositoryDto;
use App\Service\GithubStatistics\Model\GithubStatisticsModel;

class GithubStatisticsBuilderDirector
{
    public function __construct(
        private readonly GithubStatisticsBuilderInterface $builder
    ) {
    }

    public function build(GithubRepositoryDto $githubRepositoryDto): GithubStatisticsModel
    {
        $this->builder
            ->buildRepositoryBasicData($githubRepositoryDto)
            ->buildRepositoryStatistics($githubRepositoryDto)
            ->buildPullRequestStatistics($githubRepositoryDto)
            ->buildReleaseStatistics($githubRepositoryDto);

        return $this->builder->getStatisticsModel();
    }
}
