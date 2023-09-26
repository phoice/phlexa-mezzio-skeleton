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

use Application\Config\PipelineDelegatorFactory;
use Interop\Container\ContainerInterface;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Mezzio\Application;
use Mezzio\Handler\NotFoundHandler;
use Mezzio\Helper\ServerUrlMiddleware;
use Mezzio\Helper\UrlHelperMiddleware;
use Mezzio\Router\Middleware\DispatchMiddleware;
use Mezzio\Router\Middleware\ImplicitHeadMiddleware;
use Mezzio\Router\Middleware\ImplicitOptionsMiddleware;
use Mezzio\Router\Middleware\MethodNotAllowedMiddleware;
use Mezzio\Router\Middleware\RouteMiddleware;
use PhlexaMezzio\Middleware\CheckApplicationMiddleware;
use PhlexaMezzio\Middleware\ConfigureSkillMiddleware;
use PhlexaMezzio\Middleware\LogAlexaRequestMiddleware;
use PhlexaMezzio\Middleware\SetLocaleMiddleware;
use PhlexaMezzio\Middleware\ValidateCertificateMiddleware;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class PipelineDelegatorFactoryTest
 *
 * @package ApplicationTest\Config
 */
class PipelineDelegatorFactoryTest extends TestCase
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

        $application->expects($this->any())->method('pipe')->with(NotFoundHandler::class);
        $application->expects($this->any())->method('pipe')->with(ErrorHandler::class);
        $application->expects($this->any())->method('pipe')->with(ServerUrlMiddleware::class);
        $application->expects($this->any())->method('pipe')->with(RouteMiddleware::class);
        $application->expects($this->any())->method('pipe')->with(ConfigureSkillMiddleware::class);
        $application->expects($this->any())->method('pipe')->with(LogAlexaRequestMiddleware::class);
        $application->expects($this->any())->method('pipe')->with(CheckApplicationMiddleware::class);
        $application->expects($this->any())->method('pipe')->with(ValidateCertificateMiddleware::class);
        $application->expects($this->any())->method('pipe')->with(SetLocaleMiddleware::class);
        $application->expects($this->any())->method('pipe')->with(ImplicitHeadMiddleware::class);
        $application->expects($this->any())->method('pipe')->with(ImplicitOptionsMiddleware::class);
        $application->expects($this->any())->method('pipe')->with(MethodNotAllowedMiddleware::class);
        $application->expects($this->any())->method('pipe')->with(UrlHelperMiddleware::class);
        $application->expects($this->any())->method('pipe')->with(DispatchMiddleware::class);
        $application->expects($this->any())->method('pipe')->with(NotFoundHandler::class);

        $callable = function () use ($application) {
            return $application;
        };

        $factory = new PipelineDelegatorFactory();

        $applicationReturn = $factory($container, Application::class, $callable);

        $this->assertEquals($applicationReturn, $application);
    }
}
