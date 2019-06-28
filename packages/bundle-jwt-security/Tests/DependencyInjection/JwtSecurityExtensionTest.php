<?php

namespace SnakeTn\JwtSecurityBundle\Tests;

use PHPUnit\Framework\TestCase;
use SnakeTn\JwtSecurityBundle\DependencyInjection\JwtSecurityExtension;
use Symfony\Bundle\SecurityBundle\DependencyInjection\SecurityExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class JwtSecurityExtensionTest extends TestCase
{
    public function testSecurityConfiguration()
    {
        $container = $this->getContainer();
        $config = $container->getExtensionConfig("security");
    }

    public function getContainer(): ContainerBuilder
    {
        $container = new ContainerBuilder();
        $container->registerExtension(new JwtSecurityExtension());
        $container->registerExtension(new SecurityExtension());

        $container->compile();
        return $container;
    }
}