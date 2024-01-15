<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Core\Application;
use Core\Services\ConfigService;
use Core\Services\ContainerService;
use Router\Services\RoutingService;

$config = new ConfigService();

$containerService = new ContainerService();

$routingService = new RoutingService();

$app = new Application($config, $containerService, $routingService);

$app->bootstrap();

$app->initQueueService();

$app->initRouter();

$app->run();