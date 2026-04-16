<?php

require __DIR__ . '/../vendor/autoload.php';

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

use Src\Application\UseCases\MovementRankingUseCase;
use Src\Infrastructure\Database\Connection;
use Src\Infrastructure\Repository\MovementRepositoryPDO;
use Src\Infrastructure\Repository\PersonalRecordRepositoryPDO;
use Src\Http\Binder\MovementRouteBinder;
use Src\Http\Controllers\MovementController;
use Src\Http\Resolver\MovementResolver;
use Src\Http\Response\ResponsePayload;

header('Content-Type: application/json');

$dispatcher = simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/api/movement/{movement}/ranking', function ($params) {

        $pdo = Connection::get();

        $movementRepository = new MovementRepositoryPDO($pdo);
        $personalRecordRepository = new PersonalRecordRepositoryPDO($pdo);
        $useCase = new MovementRankingUseCase($personalRecordRepository);

        $resolver = new MovementResolver($movementRepository);
        $movement = $resolver($params['movement']);

        if (!$movement) {
            http_response_code(404);
            echo json_encode([
                'type' => 'error',
                'message' => 'movement not found'
            ]);
            return;
        }       

        $controller = new MovementController($useCase);
        $response = $controller->show($movement);

        http_response_code(200);
        echo json_encode($response);

    });

});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {

    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo json_encode(ResponsePayload::error('not found'));
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo json_encode(ResponsePayload::error('method not allowed'));
        break;

    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $params = $routeInfo[2] ?? [];

        $handler($params);
        break;
}