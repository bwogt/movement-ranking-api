<?php

namespace Tests\Integration\Infrastructure\Repository;

use Src\Domain\Entity\Movement;
use Src\Infrastructure\Repository\MovementRepositoryPDO;
use Tests\Integration\IntegrationTestCase;

final class MovementRepositoryPDOTest extends IntegrationTestCase
{
    private MovementRepositoryPDO $rep;

    public function setUp(): void
    {
        parent::setUp();
        $this->rep = new MovementRepositoryPDO($this->pdo);
    }

    public function test_should_return_movement_instance_when_found_by_id(): void
    {
        $this->assertInstanceOf(Movement::class, $this->rep->findById(1));
    }

    public function test_should_return_null_when_movement_id_does_not_exist(): void
    {
        $this->assertNull($this->rep->findById(0));
    }

    public function test_should_return_correct_movement_data_when_finding_by_id(): void
    {
        $movement = $this->rep->findById(3);

        $this->assertEquals(3, $movement->id);
        $this->assertEquals('Bench Press', $movement->name);
    }

    public function test_should_return_movement_instance_when_found_by_name(): void
    {
        $this->assertInstanceOf(Movement::class, $this->rep->findByName('Back Squat'));
    }

    public function test_should_return_null_when_movement_name_does_not_exist(): void
    {
        $this->assertNull($this->rep->findByName(''));
    }

    public function test_should_return_correct_movement_data_when_finding_by_name(): void
    {
        $movement = $this->rep->findByName('Deadlift');

        $this->assertEquals(1, $movement->id);
        $this->assertEquals('Deadlift', $movement->name);
    }

    public function test_should_find_movement_by_name_ignoring_case(): void
    {
        //is listed as “Bench Press” in the database (via seed/02-seed.sql)
        $movement = $this->rep->findByName('bench press'); 
        
        $this->assertNotNull($movement);
        $this->assertEquals('Bench Press', $movement->name);
    }
}