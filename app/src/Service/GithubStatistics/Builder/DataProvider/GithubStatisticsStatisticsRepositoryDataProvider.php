<?php

declare(strict_types=1);

namespace App\Service\GithubStatistics\Builder\DataProvider;

use App\Dto\GithubRepositoryDto;
use App\Service\GithubStatistics\ValueObject\GithubStatisticsUrl;
use Webmozart\Assert\Assert;

class GithubStatisticsStatisticsRepositoryDataProvider extends GithubStatisticsAbstractDataProvider
{
    private const PATH_PATTERN = 'repos/%s/%s';

    /**
     * @inheritDoc
     */
    public function provide(GithubRepositoryDto $githubRepositoryDto): array
    {
        $response = $this->client
            ->get(
                new GithubStatisticsUrl(
                    sprintf(
                        self::PATH_PATTERN,
                        $githubRepositoryDto->getUserName(),
                        $githubRepositoryDto->getRepositoryName()
                    )
                )
            );

        Assert::keyExists($response, 'stargazers_count');
        Assert::keyExists($response, 'subscribers_count');
        Assert::keyExists($response, 'forks');

        return [
            'stars' => (int)$response['stargazers_count'],
            'watchers' => (int)$response['subscribers_count'],
            'forks' => (int)$response['forks'],
        ];
    }
}
