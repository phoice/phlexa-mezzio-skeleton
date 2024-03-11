<?php

namespace Application\Logger;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class LoggerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param mixed[]|null       $options
     *
     * @return object
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): object
    {
        $config = $container->get('config');

        $logger = new Logger();
        $logger->setLogConfig($config['log_config']);
        return $logger;
    }
}
