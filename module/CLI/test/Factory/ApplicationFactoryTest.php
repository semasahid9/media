<?php

declare(strict_types=1);

namespace ShlinkioTest\Shlink\CLI\Factory;

use Laminas\ServiceManager\ServiceManager;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Shlinkio\Shlink\CLI\Factory\ApplicationFactory;
use Shlinkio\Shlink\Core\Options\AppOptions;
use ShlinkioTest\Shlink\CLI\CliTestUtilsTrait;

class ApplicationFactoryTest extends TestCase
{
    use CliTestUtilsTrait;

    private ApplicationFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new ApplicationFactory();
    }

    #[Test]
    public function allCommandsWhichAreServicesAreAdded(): void
    {
        $sm = $this->createServiceManager([
            'commands' => [
                'foo' => 'foo',
                'bar' => 'bar',
                'baz' => 'baz',
            ],
        ]);
        $sm->setService('foo', $this->createCommandMock('foo'));
        $sm->setService('bar', $this->createCommandMock('bar'));

        $instance = ($this->factory)($sm);

        self::assertTrue($instance->has('foo'));
        self::assertTrue($instance->has('bar'));
        self::assertFalse($instance->has('baz'));
    }

    private function createServiceManager(array $config = []): ServiceManager
    {
        return new ServiceManager(['services' => [
            'config' => [
                'cli' => $config,
            ],
            AppOptions::class => new AppOptions(),
        ]]);
    }
}
