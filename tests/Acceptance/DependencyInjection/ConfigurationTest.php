<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\Tests\Acceptance\DependencyInjection;

use Answear\FanCourierBundle\ConfigProvider;
use Answear\FanCourierBundle\DependencyInjection\AnswearFanCourierExtension;
use Answear\FanCourierBundle\DependencyInjection\Configuration;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    #[Test]
    #[DataProvider('provideValidConfig')]
    public function validTest(array $configs): void
    {
        $this->assertConfigurationIsValid($configs);

        $extension = $this->getExtension();

        $builder = new ContainerBuilder();
        $extension->load($configs, $builder);

        $configProviderDefinition = $builder->getDefinition(ConfigProvider::class);

        self::assertSame($configs[0]['username'], $configProviderDefinition->getArgument(0));
        self::assertSame($configs[0]['password'], $configProviderDefinition->getArgument(1));
        self::assertSame($configs[0]['apiUrl'], $configProviderDefinition->getArgument(2));
    }

    #[Test]
    #[DataProvider('provideInvalidConfig')]
    public function invalidConfig(array $config, ?string $expectedMessage = null): void
    {
        $this->assertConfigurationIsInvalid(
            $config,
            $expectedMessage
        );
    }

    #[Test]
    #[DataProvider('provideInvalidLogger')]
    public function invalidLogger(array $configs, \Throwable $expectedException): void
    {
        $this->expectException(get_class($expectedException));
        $this->expectExceptionMessage($expectedException->getMessage());

        $this->assertConfigurationIsValid($configs);

        $extension = $this->getExtension();

        $builder = new ContainerBuilder();
        $extension->load($configs, $builder);
    }

    public static function provideInvalidConfig(): iterable
    {
        yield [
            [
                [],
            ],
            '"answear_fan_courier" must be configured.',
        ];

        yield [
            [
                [
                    'username' => 'username',
                ],
            ],
            'answear_fan_courier" must be configured.',
        ];

        yield [
            [
                [
                    'password' => 'password',
                ],
            ],
            'answear_fan_courier" must be configured.',
        ];

        yield [
            [
                [
                    'apiUrl' => 'apiUrl',
                ],
            ],
            'answear_fan_courier" must be configured.',
        ];
    }

    public static function provideInvalidLogger(): iterable
    {
        yield [
            [
                [
                    'username' => 'username',
                    'password' => 'password',
                    'apiUrl' => 'apiUrl',
                    'logger' => 'not-existing-service-name',
                ],
            ],
            new ServiceNotFoundException('not-existing-service-name'),
        ];
    }

    public static function provideValidConfig(): iterable
    {
        yield [
            [
                [
                    'username' => 'username',
                    'password' => 'password',
                    'apiUrl' => 'apiUrl',
                ],
            ],
        ];

        yield [
            [
                [
                    'username' => 'kimi',
                    'password' => 'password',
                    'apiUrl' => 'api.fancourier.ro',
                ],
            ],
        ];
    }

    protected function getContainerExtensions(): array
    {
        return [$this->getExtension()];
    }

    protected function getConfiguration(): Configuration
    {
        return new Configuration();
    }

    private function getExtension(): AnswearFanCourierExtension
    {
        return new AnswearFanCourierExtension();
    }
}
