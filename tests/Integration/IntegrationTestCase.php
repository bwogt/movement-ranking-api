<?php

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use Src\Infrastructure\Database\Connection;
use PDO;

abstract class IntegrationTestCase extends TestCase
{
    protected PDO $pdo;

    protected function setUp(): void
    {
        parent::setUp();
        Connection::reset();

        $this->pdo = Connection::get();
        
        if (!$this->pdo->inTransaction()) {
            $this->pdo->beginTransaction();
        }
    }

    protected function tearDown(): void
    {
        if (isset($this->pdo) && $this->pdo->inTransaction()) {
            $this->pdo->rollBack();
        }

        parent::tearDown();
    }
}