<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\GithubStatistics\Builder\DataProvider;

use App\Dto\GithubRepositoryDto;
use App\Service\GithubStatistics\Builder\DataProvider\GithubStatisticsStatisticsReleaseDataProvider;
use App\Service\GithubStatistics\Client\GithubStatisticsClient;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GithubStatisticsStatisticsReleaseDataProviderTest extends TestCase
{
    private GithubStatisticsClient&MockObject $mockClient;
    private GithubRepositoryDto&MockObject $mockRepositoryDto;

    private GithubStatisticsStatisticsReleaseDataProvider $dataProvider;

    protected function setUp(): void
    {
        $this->mockClient = $this->createMock(GithubStatisticsClient::class);
        $this->mockRepositoryDto = $this->createMock(GithubRepositoryDto::class);
        $this->dataProvider = new GithubStatisticsStatisticsReleaseDataProvider(
            $this->mockClient,
        );
    }

    /**
     * @param array<string, string> $data
     *
     * @dataProvider correctDataProvider
     */
    public function testCorrectData(array $data, ?string $expectedValue): void
    {
        $this->mockClient->method('get')->willReturn($data);
        $response = $this->dataProvider->provide($this->mockRepositoryDto);

        self::assertSame($expectedValue, $response['lastReleaseDate']);
    }

    /**
     * @return array<int, mixed>
     */
    public static function correctDataProvider(): array
    {
        return [
            [
                [
                    'published_at' => '2023-01-01 11:00:00',
                ],
                '2023-01-01 11:00:00',
            ],
            [
                [],
                null,
            ],
        ];
    }
}
