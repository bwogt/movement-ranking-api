<?php

namespace Src\Application\UseCases;

use Src\Domain\Entity\Movement;
use Src\Domain\Repository\PersonalRecordRepository;

final class MovementRankingUseCase
{
    public function __construct(
        private readonly PersonalRecordRepository $repository
    ) {}
    
    public function __invoke(Movement $movement): array
    {
        $records = $this->movementRecords($movement);

        return $this->buildRanking($records);
    }

    private function movementRecords(Movement $movement): array
    {
        return $this->repository->findAllLeadingRecords($movement);
    }

    private function buildRanking(array $records): array
    {
        $ranking = [];
        $currentRanking = 0;
        $lastValue = null;

        foreach ($records as $record) {
            $this->updatePosition( $record['value'], $lastValue, $currentRanking);
            $ranking[] = $this->formatRow($currentRanking, $record);
            $lastValue =  $record['value'];
        }

        return $ranking;
    }

    private function updatePosition(float $currentValue, ?float $lastValue, int &$currentRanking): void
    {
        if ($currentValue !== $lastValue) {
            $currentRanking++;
        }
    }

    private function formatRow(int $currentRanking, array $record): array
    {
        return [
            'position'  => $currentRanking,
            'user'      => $record['user_name'],
            'value'     =>  $record['value'],
            'date'      => $record['date'],
        ];
    }
}