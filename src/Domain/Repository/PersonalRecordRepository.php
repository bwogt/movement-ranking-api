<?php

namespace Src\Domain\Repository;

use Src\Domain\Entity\Movement;

interface PersonalRecordRepository {
    public function findAllLeadingRecords(Movement $movement): array;
}