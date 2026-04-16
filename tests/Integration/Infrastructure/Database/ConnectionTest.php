<?php

namespace Tests\Integration\Infrastructure\Database;

use Src\Infrastructure\Database\Connection;
use Tests\Integration\IntegrationTestCase;

class ConnectionTest extends IntegrationTestCase
{
    public function test_should_connect_to_the_database(): void
    {
        $dbName = $this->pdo
            ->query("SELECT DATABASE()")
            ->fetchColumn();

        $this->assertEquals('db_test', $dbName);
    }

    public function test_should_be_able_to_run_queries(): void
    {
        $stmt = $this->pdo->query("SELECT 1 as number");
        $result = $stmt->fetch();

        $this->assertEquals(1, $result['number']);
    }

    public function test_should_return_same_instance_singleton(): void
    {
        Connection::reset();

        $conn1 = Connection::get();
        $conn2 = Connection::get();

        $this->assertSame($conn1, $conn2);
    }
}