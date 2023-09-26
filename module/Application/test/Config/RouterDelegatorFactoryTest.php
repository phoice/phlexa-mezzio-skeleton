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

namespace ApplicationTest\Config;

use Application\Config\RouterDelegatorFactory;
use Application\Handler\HomePageHandler;
use Interop\Container\ContainerInterface;
use Mezzio\Application;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class RouterDelegatorFactoryTest
 *
 * @package ApplicationTest\Config
 */
class RouterDelegatorFactoryTest extends TestCase
{
    /**
     *
     */
    public function testFactory()
    {
        /** @var ContainerInterface|MockObject $container */
        $container = $this->createMock(ContainerInterface::class);

        /** @var Application|MockObject $application */
        $application = $this->createMock(Application::class);

        $application->expects($this->any())
            ->method('route')
            ->with('/', HomePageHandler::class, ['GET', 'POST'], 'home');

        $callable = function () use ($application) {
            return $application;
        };

        $factory = new RouterDelegatorFactory();

        $applicationReturn = $factory($container, Application::class, $callable);

        $this->assertEquals($applicationReturn, $application);
    }
}
