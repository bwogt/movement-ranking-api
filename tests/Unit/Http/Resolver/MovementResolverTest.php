<?php

namespace Tests\Unit\Http\Resolver;

use PHPUnit\Framework\TestCase;
use Src\Domain\Entity\Movement;
use Src\Domain\Repository\MovementRepository;
use Src\Http\Resolver\MovementResolver;

final class MovementResolverTest extends TestCase
{
    private $repositoryMock;
    private MovementResolver $movementResolver;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositoryMock = $this->createMock(MovementRepository::class);
        $this->movementResolver = new MovementResolver($this->repositoryMock);
    }

    public function test_should_resolves_movement_by_id(): void
    {
        $this->repositoryMock->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn(new Movement(1, 'Bench Press'));

        $this->repositoryMock->expects($this->never())->method('findByName');

        $result = ($this->movementResolver)('1');

        $this->assertInstanceOf(Movement::class, $result);
        $this->assertEquals('Bench Press', $result->name);
    }

    public function test_should_resolves_movement_by_name(): void
    {
        $this->repositoryMock->expects($this->once())
            ->method('findByName')
            ->with('Bench Press')
            ->willReturn(new Movement(1, 'Bench Press'));

        $this->repositoryMock->expects($this->never())->method('findById');

        $result = ($this->movementResolver)('Bench Press');

        $this->assertInstanceOf(Movement::class, $result);
        $this->assertEquals('Bench Press', $result->name);
    }

    public function test_should_returns_null_when_not_found(): void
    {
        $this->repositoryMock->expects($this->once())
            ->method('findById')
            ->with(0)
            ->willReturn(null);

        $result = ($this->movementResolver)('0');
        $this->assertNull($result);
    }
}