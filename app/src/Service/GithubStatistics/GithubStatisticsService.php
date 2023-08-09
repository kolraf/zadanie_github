<?php

declare(strict_types=1);

namespace App\Service\GithubStatistics;

use App\Dto\GithubRepositoriesDto;
use App\Service\GithubStatistics\Builder\GithubStatisticsBuilderDirector;
use App\Service\GithubStatistics\Model\GithubStatisticsModel;
use App\Service\GithubStatistics\Sorter\GithubStatisticsSorter;

class GithubStatisticsService
{
    public function __construct(
        private readonly GithubStatisticsBuilderDirector $builderDirector,
        private readonly GithubStatisticsSorter $sorter
    ) {
    }

    /**
     * @return GithubStatisticsModel[]
     */
    public function getStatistics(GithubRepositoriesDto $githubRepositoriesDto): array
    {
        $statistics = [];

        foreach ($githubRepositoriesDto->getRepositories() as $githubRepositoryDto) {
            $statistics[] = $this->builderDirector->build($githubRepositoryDto);
        }

        return $this->sorter->sortByActivity($statistics);
    }
}
