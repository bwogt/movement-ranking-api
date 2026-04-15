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
}