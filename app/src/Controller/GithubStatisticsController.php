<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\GithubRepositoriesDto;
use App\Service\GithubStatistics\GithubStatisticsService;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[AsController]
class GithubStatisticsController
{
    public function __construct(
        private readonly GithubStatisticsService $githubStatisticsService,
        private readonly NormalizerInterface $normalizer
    ) {
    }

    #[Route('/api/github-statistics', name: 'github-statistics', methods: ['POST'])]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(
                    property: 'repositories',
                    type: 'array',
                    items: new OA\Items(),
                    example: [
                        [
                            'userName' => 'doctrine',
                            'repositoryName' => 'orm'
                        ],
                        [
                            'userName' => 'symfony',
                            'repositoryName' => 'symfony'
                        ]
                    ]
                ),
            ]
        )
    )]
    public function __invoke(
        #[MapRequestPayload] GithubRepositoriesDto $urlsDto,
    ): JsonResponse {
        return new JsonResponse(
            $this->normalizer->normalize(
                $this->githubStatisticsService->getStatistics($urlsDto),
            ),
        );
    }
}
