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

namespace HelloTest\Config;

use Hello\Config\RouterDelegatorFactory;
use Hello\ConfigProvider;
use Interop\Container\ContainerInterface;
use Mezzio\Application;
use Mezzio\Router\Route;
use PhlexaMezzio\Handler\HtmlPageHandler;
use PhlexaMezzio\Handler\SkillHandler;
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

        /** @var Route|MockObject $route1 */
        $route1 = $this->createMock(Route::class);

        $route1->expects($this->any())
            ->method('setOptions')
            ->with(['defaults' => ['skillName' => ConfigProvider::NAME]]);

        $application->expects($this->any())
            ->method('post')
            ->with('/hello', SkillHandler::class, 'hello')
            ->willReturn($route1);

        /** @var Route|MockObject $route2 */
        $route2 = $this->createMock(Route::class);

        $route2->expects($this->once())
            ->method('setOptions')
            ->with(['defaults' => ['template' => 'hello::privacy']]);

        $application->expects($this->once())
            ->method('get')
            ->with('/hello/privacy', HtmlPageHandler::class, 'hello-privacy')
            ->willReturn($route2);

        /** @var Route|MockObject $route3 */
        $route3 = $this->createMock(Route::class);

        $route3->expects($this->once())
            ->method('setOptions')
            ->with(['defaults' => ['template' => 'hello::terms']]);

        $application->expects($this->once())
            ->method('get')
            ->with('/hello/terms', HtmlPageHandler::class, 'hello-terms')
            ->willReturn($route3);

        $callable = function () use ($application) {
            return $application;
        };

        $factory = new RouterDelegatorFactory();

        $applicationReturn = $factory($container, Application::class, $callable);

        $this->assertEquals($applicationReturn, $application);
    }
}
