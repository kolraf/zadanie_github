<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\GithubStatistics\Builder\DataProvider;

use App\Dto\GithubRepositoryDto;
use App\Service\GithubStatistics\Builder\DataProvider\GithubStatisticsStatisticsPullRequestDataProvider;
use App\Service\GithubStatistics\Client\GithubStatisticsClient;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GithubStatisticsStatisticsPullRequestDataProviderTest extends TestCase
{
    private GithubStatisticsClient&MockObject $mockClient;
    private GithubRepositoryDto&MockObject $mockRepositoryDto;

    private GithubStatisticsStatisticsPullRequestDataProvider $dataProvider;

    protected function setUp(): void
    {
        $this->mockClient = $this->createMock(GithubStatisticsClient::class);
        $this->mockRepositoryDto = $this->createMock(GithubRepositoryDto::class);
        $this->dataProvider = new GithubStatisticsStatisticsPullRequestDataProvider(
            $this->mockClient,
        );
    }

    /**
     * @param array<int, mixed> $data
     * @param array<string, mixed> $expectedValue
     *
     * @dataProvider correctDataProvider
     */
    public function testCorrectData(array $data, array $expectedValue): void
    {
        $this->mockClient->method('get')->willReturn(...$data);
        $response = $this->dataProvider->provide($this->mockRepositoryDto);

        self::assertSame($expectedValue['lastMergedPullRequestDate'], $response['lastMergedPullRequestDate']);
        self::assertSame($expectedValue['lastPullRequestDate'], $response['lastPullRequestDate']);
        self::assertSame($expectedValue['numberOfClosedPullRequests'], $response['numberOfClosedPullRequests']);
        self::assertSame($expectedValue['numberOfOpenPullRequests'], $response['numberOfOpenPullRequests']);
    }

    /**
     * @param array<int, mixed> $data
     *
     * @dataProvider incorrectDataProvider
     */
    public function testIncorrectData(array $data, string $missingKey): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage(sprintf('Expected the key "%s" to exist.', $missingKey));

        $this->mockClient->method('get')->willReturn(...$data);
        $this->dataProvider->provide($this->mockRepositoryDto);
    }

    /**
     * @return array<int, mixed>
     */
    public static function correctDataProvider(): array
    {
        return [
            [
                [
                    ['items' => [0 => ['commit' => ['committer' => ['date' => '2023-01-01 10:00:00']]]]],
                    [0 => ['created_at' => '2023-01-02 11:00:00']],
                    ['total_count' => 1],
                    ['total_count' => 2],
                ],
                [
                    'lastMergedPullRequestDate' => '2023-01-01 10:00:00',
                    'lastPullRequestDate' => '2023-01-02 11:00:00',
                    'numberOfClosedPullRequests' => 1,
                    'numberOfOpenPullRequests' => 2,
                ],
            ],
            [
                [
                    [],
                    [0 => ['created_at' => '2023-01-02 11:00:00']],
                    ['total_count' => 1],
                    ['total_count' => 2],
                ],
                [
                    'lastMergedPullRequestDate' => null,
                    'lastPullRequestDate' => '2023-01-02 11:00:00',
                    'numberOfClosedPullRequests' => 1,
                    'numberOfOpenPullRequests' => 2,
                ],
            ],
            [
                [
                    [],
                    [],
                    ['total_count' => 1],
                    ['total_count' => 2],
                ],
                [
                    'lastMergedPullRequestDate' => null,
                    'lastPullRequestDate' => null,
                    'numberOfClosedPullRequests' => 1,
                    'numberOfOpenPullRequests' => 2,
                ],
            ],
        ];
    }

    /**
     * @return array<int, mixed>
     */
    public static function incorrectDataProvider(): array
    {
        return [
            [
                [
                    [],
                    [],
                    [],
                    ['total_count' => 2],
                ],
                'total_count',
            ],
            [
                [
                    [],
                    [],
                    ['total_count' => 1],
                    [],
                ],
                'total_count',
            ],
        ];
    }
}
