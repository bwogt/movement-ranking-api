<?php

namespace Src\Infrastructure\Repository;

use PDO;
use Src\Domain\Entity\Movement;
use Src\Domain\Repository\MovementRepository;

final class MovementRepositoryPDO implements MovementRepository
{
    public function __construct(
        private readonly PDO $pdo
    ) {}
    
    public function findById(int $id): ?Movement 
    {
        $sql = "SELECT id, name FROM movement WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data
            ? new Movement($data['id'], $data['name'])
            : null;
    }
}