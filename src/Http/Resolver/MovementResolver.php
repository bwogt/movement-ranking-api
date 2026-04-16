<?php

namespace Src\Http\Resolver;

use Src\Domain\Entity\Movement;
use Src\Domain\Repository\MovementRepository;

final class MovementResolver
{
    public function __construct(
        private MovementRepository $repository
    ) {}

    public function __invoke(string $value): ?Movement
    {
        $value = $this->normalize($value);

        if (is_numeric($value)) {
            return $this->repository->findById((int)$value);
        } 
            
        return $this->repository->findByName($value);
    }

    private function normalize(string $value): string
    {
        return trim(urldecode($value));
    }
}