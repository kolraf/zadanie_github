<?php

declare(strict_types=1);

namespace App\Service\GithubStatistics\Builder\DataProvider;

use App\Dto\GithubRepositoryDto;
use App\Service\GithubStatistics\ValueObject\GithubStatisticsUrl;

class GithubStatisticsStatisticsReleaseDataProvider extends GithubStatisticsAbstractDataProvider
{
    private const LATEST_RELEASE_PATH_PATTERN = 'repos/%s/%s/releases/latest';

    /**
     * @inheritDoc
     */
    public function provide(GithubRepositoryDto $githubRepositoryDto): array
    {
        $response = $this->client
            ->get(
                new GithubStatisticsUrl(
                    sprintf(
                        self::LATEST_RELEASE_PATH_PATTERN,
                        $githubRepositoryDto->getUserName(),
                        $githubRepositoryDto->getRepositoryName()
                    )
                )
            );

        return [
            'lastReleaseDate' => $response['published_at'] ?? null,
        ];
    }
}
