<?php

declare(strict_types=1);

namespace App\Service\GithubStatistics\Sorter;

use App\Service\GithubStatistics\Model\GithubStatisticsModel;
use DateTime;
use Webmozart\Assert\Assert;

class GithubStatisticsSorter
{
    private const MAX_DATE_INTERVAL_IN_DAYS = '90';

    private const ALIVE_PROJECT = 1.3;
    private const DEAD_PROJECT = 0.7;

    /**
     * @param GithubStatisticsModel[] $statistics
     *
     * @return GithubStatisticsModel[]
     */
    public function sortByActivity(array $statistics): array
    {
        Assert::allIsInstanceOf($statistics, GithubStatisticsModel::class);
        $rating = [];

        foreach ($statistics as $statisticsModel) {
            $rating[] = [
                'rate' => $this->calculateRepositoryRating($statisticsModel),
                'statisticsModel' => $statisticsModel,
            ];
        }

        usort($rating, function ($record1, $record2) {
            return $record2['rate'] <=> $record1['rate'];
        });

        return array_column($rating, 'statisticsModel');
    }

    private function calculateRepositoryRating(GithubStatisticsModel $statisticsModel): int
    {
        $rating = $statisticsModel->getStars() + $statisticsModel->getWatchers();

        $now = new DateTime();
        $lastReleaseDateTime = new DateTime($statisticsModel->getLastReleaseDate());
        $isProjectAlive = $now->diff($lastReleaseDateTime)->days < self::MAX_DATE_INTERVAL_IN_DAYS;

        $rating = $isProjectAlive ? $rating * self::ALIVE_PROJECT : $rating * self::DEAD_PROJECT;

        return (int)round($rating);
    }
}
