<?php

namespace Src\Infrastructure\Repository;

use PDO;
use Src\Domain\Entity\Movement;
use Src\Domain\Repository\PersonalRecordRepository;

final class PersonalRecordRepositoryPDO implements PersonalRecordRepository
{
    public function __construct(
        private readonly PDO $pdo
    ) {}
    
    public function findAllLeadingRecords(Movement $movement): array
    {
        $sql = "SELECT 
                    pr.value, 
                    pr.date, 
                    u.name as user_name
                FROM personal_record pr
                JOIN user u ON pr.user_id = u.id
                WHERE pr.movement_id = :movement_id
                ORDER BY pr.value DESC, u.name ASC;";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['movement_id' => $movement->id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}