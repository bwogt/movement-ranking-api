<?php

namespace Tests\Unit\Application\UseCases;

use PHPUnit\Framework\TestCase;
use Src\Application\UseCases\MovementRankingUseCase;
use Src\Domain\Entity\Movement;
use Src\Domain\Repository\PersonalRecordRepository;

final class MovementRankingUseCaseTest extends TestCase
{
    private function runServiceWithRecord(array $records): array
    {
        $repositoryMock = $this->createMock(PersonalRecordRepository::class);

        $repositoryMock->expects($this->once())
            ->method('findAllLeadingRecords')
            ->willReturn($records);
        
        $service = new MovementRankingUseCase($repositoryMock);
        return $service(new Movement(1, 'Test'));
    }

    public function test_should_assign_sequential_positions_for_different_values(): void
    {
        $ranking = $this->runServiceWithRecord([
            ['value' => 100, 'user_name' => 'A', 'date' => '2026-01-01'],
            ['value' => 80,  'user_name' => 'B', 'date' => '2026-01-02'],
            ['value' => 70,  'user_name' => 'B', 'date' => '2026-01-02'],
        ]);

        $this->assertEquals(1, $ranking[0]['position']);
        $this->assertEquals(2, $ranking[1]['position']);
        $this->assertEquals(3, $ranking[2]['position']);
    }

    public function test_should_keep_same_rank_when_values_are_equal(): void
    {
        $ranking = $this->runServiceWithRecord([
            ['value' => 100.2, 'user_name' => 'A', 'date' => '2026-01-01'],
            ['value' => 100.2, 'user_name' => 'B', 'date' => '2026-01-02'],
            ['value' => 100.1, 'user_name' => 'A', 'date' => '2026-01-02'],
        ]);

        $this->assertEquals(1, $ranking[0]['position']);
        $this->assertEquals(1, $ranking[1]['position']);
        $this->assertEquals(2, $ranking[2]['position']);
    }
}