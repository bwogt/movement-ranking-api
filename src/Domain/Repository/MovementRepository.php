<?php

namespace Src\Domain\Repository;

use Src\Domain\Entity\Movement;

interface MovementRepository {
    public function findById(int $id): ?Movement;
    public function findByName(string $name): ?Movement;
}