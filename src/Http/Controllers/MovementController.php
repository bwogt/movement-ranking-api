<?php

namespace Src\Http\Controllers;

use Src\Application\UseCases\MovementRankingUseCase;
use Src\Domain\Entity\Movement;
use Src\Http\Response\ResponsePayload;

final class MovementController
{
    public function __construct(
        private MovementRankingUseCase $useCase
    ) {}

    public function show(Movement $movement): array
    {
        $ranking = ($this->useCase)($movement);

        return ResponsePayload::success(
            message: 'Ranking obtido com sucesso',
            data: [
                'movement_name' => $movement->name,
                'ranking' => $ranking
            ]
        );
    }
}