<?php

namespace Src\Domain\Entity;

use DateTime;

final class PersonalRecord
{
    public function __construct(
        public int $id,
        public int $user_id,
        public int $movement_id,
        public float $value,
        public DateTime $date,
    ) {}
}