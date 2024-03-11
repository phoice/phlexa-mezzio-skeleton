<?php

namespace Application\Middleware;

use Application\Logger\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Laminas\Stratigility\Middleware\ErrorHandler;

class LoggingErrorListenerDelegatorFactory
{
    public function __invoke(ContainerInterface $container, string $name, callable $callback) : ErrorHandler
    {
        $listener = new LoggingErrorListener($container->get(Logger::class));
        $errorHandler = $callback();
        $errorHandler->attachListener($listener);
        return $errorHandler;
    }
}
