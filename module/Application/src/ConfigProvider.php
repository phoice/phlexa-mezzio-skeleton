<?php
/**
 * Skeleton application to build voice applications for Amazon Alexa with phlexa, PHP and Mezzio
 *
 * @author     Ralf Eggert <ralf@travello.audio>
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/phoice/phlexa-mezzio-skeleton
 * @link       https://www.phoice.tech/
 * @link       https://www.travello.audio/
 */

declare(strict_types=1);

namespace Application;

use Application\Handler\HomePageHandler;
use Application\Config\PipelineDelegatorFactory;
use Application\Config\RouterDelegatorFactory;
use Application\Logger\Logger;
use Application\Logger\LoggerFactory;
use Application\Middleware\LoggingErrorListenerDelegatorFactory;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Mezzio\Application;
use Laminas\ServiceManager\Factory\InvokableFactory;

/**
 * Class ConfigProvider
 *
 * @package Application
 */
class ConfigProvider
{
    /**
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            'delegators' => [
                Application::class => [
                    RouterDelegatorFactory::class,
                    PipelineDelegatorFactory::class,
                ],
                ErrorHandler::class => [
                    LoggingErrorListenerDelegatorFactory::class,
                ],
            ],
            'factories'  => [
                HomePageHandler::class => InvokableFactory::class,
                Logger::class          => LoggerFactory::class,
            ],
        ];
    }

    /**
     * @return array
     */
    public function getTemplates(): array
    {
        return [
            'layout' => 'layout/default',
            'map'    => [
                'layout/default' => __DIR__ . '/../templates/layout/default.phtml',
                'error/error'    => __DIR__ . '/../templates/error/error.phtml',
                'error/404'      => __DIR__ . '/../templates/error/404.phtml',
            ],
            'paths'  => [
                'layout' => [__DIR__ . '/../templates/layout'],
                'error'  => [__DIR__ . '/../templates/error'],
            ],
        ];
    }
}
