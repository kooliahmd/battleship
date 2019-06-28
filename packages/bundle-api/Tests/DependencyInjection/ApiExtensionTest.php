<?php

namespace SnakeTn\ApiBundle\Tests;

use PHPUnit\Framework\TestCase;
use SnakeTn\ApiBundle\DependencyInjection\ApiExtension;
use SnakeTn\ApiBundle\ApiBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ApiExtensionTest extends TestCase
{
    public function testSecurityConfiguration()
    {
        $container = $this->getContainer();
        $this->assertTrue($container->hasDefinition('SnakeTn\ApiBundle\RequestBodyConverter'));
    }

    public function getContainer(): ContainerBuilder
    {
        $container = new ContainerBuilder();
        $container->registerExtension(new ApiExtension());

        $container->getCompilerPassConfig()->setOptimizationPasses([]);
        $container->getCompilerPassConfig()->setRemovingPasses([]);


        $container->loadFromExtension('api');


        $container->compile();
        return $container;
    }
}