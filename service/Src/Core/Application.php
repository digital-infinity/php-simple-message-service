<?php

declare(strict_types=1);

namespace Core;

use Core\Services\ConfigService;
use Core\Services\ContainerService;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use MongoDB\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Level;
use Queue\Controllers\QueueController;
use Queue\Services\QueueService;
use Router\Exceptions\RouteNotFoundException;
use Router\Services\RoutingService;
use Router\Documents\Route;

class Application
{
    public function __construct(
        private ConfigService $configService,
        private ContainerService $containerService,
        private RoutingService $routingService,
        private bool $running = false,
    ) {
        $configFileName = $this->configService->getConfigValue("CONFIG_FILE");

        $this->configService->initConfigFromFile(__DIR__ . '/../../Config/' . $configFileName);
    }

    public function run(): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $path = substr($uri, strpos($uri,'/'));

        if(!$this->routingService->hasRoute($path)) {
            throw new RouteNotFoundException();
        }

        $route = $this->routingService->getRoute($path);

        $request = $_REQUEST;

        $response = $route->execute($request);

        var_dump($response);
    }

    public function bootstrap(): void
    {
        if($this->running) {
            $this->containerService->get(Logger::class)->debug("Bootstrap called on already running application, doing nothing.");
            return;
        }

        $logLevel = $this->configService->getConfigValue('LOG_LEVEL', 'DEBUG');

        $logger = new Logger('application_log');
        $logger->pushHandler(new StreamHandler(__DIR__ .'/application.log', Level::fromName($logLevel)));

        $this->containerService->contain(Logger::class, $logger);

        $mongoHost = $this->configService->getConfigValue('MONGODB_HOST');
        $mongoUser = $this->configService->getConfigValue('MONGODB_USERNAME');
        $mongoPass = $this->configService->getConfigValue('MONGODB_PASSWORD');

        $client = new Client($mongoHost, ['username' => $mongoUser, 'password' => $mongoPass], ['typeMap' => DocumentManager::CLIENT_TYPEMAP]);

        $mongoConfig = new Configuration();
        $mongoConfig->setDefaultDB('simple-message');
        $mongoConfig->setProxyDir(__DIR__ . '/../../Generated/Proxies');
        $mongoConfig->setProxyNamespace('Proxies');
        $mongoConfig->setHydratorDir(__DIR__ . '/../../Generated/Hydrators');
        $mongoConfig->setHydratorNamespace('Hydrators');
        $mongoConfig->setMetadataDriverImpl(AnnotationDriver::create(__DIR__));

        $this->containerService->contain(DocumentManager::class, DocumentManager::create($client, $mongoConfig));

        $this->running = true;

        return;
    }

    public function initQueueService(): void
    {
        $this->containerService->contain(QueueService::class, new QueueService());

        /** @var QueueService */
        $queueService = $this->containerService->get(QueueService::class);

        $queueService->addQueue("default");
    }

    public function initRouter(): void
    {

        $this->routingService->addRoute(
            '/queue/messages',
            new Route(
                new QueueController($this->containerService->get(QueueService::class)),
                'getMessages',
            )
        );
    }
}