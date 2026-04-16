<?php

namespace Tests\Integration\Infrastructure\Repository;

use Src\Infrastructure\Repository\MovementRepositoryPDO;
use Src\Infrastructure\Repository\PersonalRecordRepositoryPDO;
use Tests\Integration\IntegrationTestCase;

final class PersonalRecordRepositoryPDOTest extends IntegrationTestCase
{
    private MovementRepositoryPDO $movementRep;
    private PersonalRecordRepositoryPDO $personalRecordRep;

    public function setUp(): void
    {
        parent::setUp();

        $this->movementRep = new MovementRepositoryPDO($this->pdo);
        $this->personalRecordRep = new PersonalRecordRepositoryPDO($this->pdo);
    }

    public function test_should_return_all_10_records_for_movement_with_id_1(): void
    {
        // movement with id 1 (Deadlift) has 10 records
        $movement = $this->movementRep->findById(1);
        $data = $this->personalRecordRep->findAllLeadingRecords($movement);

        $this->assertCount(10, $data);
    }

    public function test_should_return_all_7_records_for_movement_with_id_2(): void
    {
        //movement with id 2 (Back Squat) has 7 records
        $movement = $this->movementRep->findById(2);
        $data = $this->personalRecordRep->findAllLeadingRecords($movement);

        $this->assertCount(7, $data);
    }

    public function test_should_return_empty_array_when_movement_with_id_3_has_no_records(): void
    {
        // movement with id 3 (Bench Press) has no records
        $movement = $this->movementRep->findById(3);
        $data = $this->personalRecordRep->findAllLeadingRecords($movement);

        $this->assertEmpty($data);
    }

    public function test_should_return_records_ordered_by_value_descending(): void
    {
        $movement = $this->movementRep->findById(1);
        $data = $this->personalRecordRep->findAllLeadingRecords($movement);

        $lastValue = null;

        foreach ($data as $personalRecord) {
            if ($lastValue !== null) {
                $this->assertGreaterThanOrEqual(
                    $personalRecord['value'],
                    $lastValue,
                    "Ranking order failed: {$lastValue} should be higher than or equal to {$personalRecord['value']}"
                );
            }

            $lastValue = $personalRecord['value'];
        }
    }
}