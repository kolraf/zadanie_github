<?php

declare(strict_types=1);

namespace App\Service\GithubStatistics\Builder\DataProvider;

use App\Dto\GithubRepositoryDto;
use App\Service\GithubStatistics\Client\GithubStatisticsClient;

abstract class GithubStatisticsAbstractDataProvider
{
    public function __construct(
        protected readonly GithubStatisticsClient $client
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    abstract public function provide(GithubRepositoryDto $githubRepositoryDto): array;
}
