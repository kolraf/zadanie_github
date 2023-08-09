<?php

declare(strict_types=1);

namespace App\Service\GithubStatistics\Builder\DataProvider;

use App\Dto\GithubRepositoryDto;
use App\Service\GithubStatistics\ValueObject\GithubStatisticsUrl;
use Webmozart\Assert\Assert;

class GithubStatisticsStatisticsPullRequestDataProvider extends GithubStatisticsAbstractDataProvider
{
    private const LAST_PULL_REQUEST_PATH_PATTERN = 'repos/%s/%s/pulls?sort=created&direction=desc&page=1&per_page=1';
    private const LAST_MERGED_PULL_REQUEST_PATH_PATTERN =
        'search/commits?q=repo:%s/%s+merge:true&sort=committer-date&per_page=1&page=1';
    private const CLOSED_PULL_REQUEST_PATH_PATTERN = 'search/issues?q=repo:%s/%s+is:pr+is:closed&per_page=1';
    private const OPEN_PULL_REQUEST_PATH_PATTERN = 'search/issues?q=repo:%s/%s+is:pr+is:open&per_page=1';

    /**
     * @inheritDoc
     */
    public function provide(GithubRepositoryDto $githubRepositoryDto): array
    {
        return [
            'lastMergedPullRequestDate' => $this->getLastMergedPullRequestDate($githubRepositoryDto),
            'lastPullRequestDate' => $this->getLastPullRequestDate($githubRepositoryDto),
            'numberOfClosedPullRequests' => $this->getNumberOfClosedPullRequests($githubRepositoryDto),
            'numberOfOpenPullRequests' => $this->getNumberOfOpenPullRequests($githubRepositoryDto),
        ];
    }

    private function getLastMergedPullRequestDate(GithubRepositoryDto $githubRepositoryDto): ?string
    {
        $response = $this->client
            ->get(
                new GithubStatisticsUrl(
                    sprintf(
                        self::LAST_MERGED_PULL_REQUEST_PATH_PATTERN,
                        $githubRepositoryDto->getUserName(),
                        $githubRepositoryDto->getRepositoryName()
                    )
                )
            );

        return $response['items'][0]['commit']['committer']['date'] ?? null;
    }

    private function getLastPullRequestDate(GithubRepositoryDto $githubRepositoryDto): ?string
    {
        $response = $this->client
            ->get(
                new GithubStatisticsUrl(
                    sprintf(
                        self::LAST_PULL_REQUEST_PATH_PATTERN,
                        $githubRepositoryDto->getUserName(),
                        $githubRepositoryDto->getRepositoryName()
                    )
                )
            );

        return $response[0]['created_at'] ?? null;
    }

    private function getNumberOfClosedPullRequests(GithubRepositoryDto $githubRepositoryDto): int
    {
        $response = $this->client
            ->get(
                new GithubStatisticsUrl(
                    sprintf(
                        self::CLOSED_PULL_REQUEST_PATH_PATTERN,
                        $githubRepositoryDto->getUserName(),
                        $githubRepositoryDto->getRepositoryName()
                    )
                )
            );

        Assert::keyExists($response, 'total_count');

        return (int)$response['total_count'];
    }

    private function getNumberOfOpenPullRequests(GithubRepositoryDto $githubRepositoryDto): int
    {
        $response = $this->client
            ->get(
                new GithubStatisticsUrl(
                    sprintf(
                        self::OPEN_PULL_REQUEST_PATH_PATTERN,
                        $githubRepositoryDto->getUserName(),
                        $githubRepositoryDto->getRepositoryName()
                    )
                )
            );

        Assert::keyExists($response, 'total_count');

        return (int)$response['total_count'];
    }
}
