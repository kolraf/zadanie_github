<?php

declare(strict_types=1);

namespace App\Service\GithubStatistics\Client;

use App\Service\GithubStatistics\ValueObject\GithubStatisticsUrl;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubStatisticsClient
{
    private const METHOD_GET = 'GET';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * @return array<mixed, mixed>
     */
    public function get(GithubStatisticsUrl $url): array
    {
        $response = $this->httpClient->request(
            self::METHOD_GET,
            $url->getValue(),
        );

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            $this->logger->error($response->toArray(false)['message'] ?? '[Github connection] Something went wrong.');

            throw new HttpException(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                'Github api returned an unexpected response.'
            );
        }

        return $response->toArray();
    }
}
