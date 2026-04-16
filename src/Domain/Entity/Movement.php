<?php

namespace Src\Domain\Entity;

final class Movement
{
    public function __construct(
        public int $id,
        public string $name
    ) {}
}