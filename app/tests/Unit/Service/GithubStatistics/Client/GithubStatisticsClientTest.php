<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\GithubStatistics\Client;

use App\Service\GithubStatistics\Client\GithubStatisticsClient;
use App\Service\GithubStatistics\ValueObject\GithubStatisticsUrl;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GithubStatisticsClientTest extends TestCase
{
    private HttpClientInterface&MockObject $mockHttpClient;
    private LoggerInterface&MockObject $mockLogger;
    private ResponseInterface&MockObject $mockResponse;
    private GithubStatisticsUrl&MockObject $mockUrl;

    private GithubStatisticsClient $client;

    protected function setUp(): void
    {
        $this->mockHttpClient = $this->createMock(HttpClientInterface::class);
        $this->mockLogger = $this->createMock(LoggerInterface::class);
        $this->mockResponse = $this->createMock(ResponseInterface::class);
        $this->mockUrl = $this->createMock(GithubStatisticsUrl::class);
        $this->client = new GithubStatisticsClient($this->mockHttpClient, $this->mockLogger);
    }

    public function testCorrectResponse(): void
    {
        $this->mockHttpClient->method('request')->willReturn($this->mockResponse);
        $this->mockResponse->expects($this->exactly(1))->method('getStatusCode')->willReturn(200);
        $this->mockLogger->expects($this->exactly(0))->method('error');

        $this->client->get($this->mockUrl);
    }

    public function testIncorrectResponse(): void
    {
        self::expectException(HttpException::class);
        self::expectExceptionMessage('Github api returned an unexpected response.');

        $this->mockHttpClient->method('request')->willReturn($this->mockResponse);
        $this->mockResponse->expects($this->exactly(1))->method('getStatusCode')->willReturn(403);
        $this->mockLogger->expects($this->exactly(1))->method('error');

        $this->client->get($this->mockUrl);
    }
}
