<?php

declare(strict_types=1);

namespace Answear\FanCourier\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class AnswearFanCourierExtension extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container): void
    {
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
    }
}
