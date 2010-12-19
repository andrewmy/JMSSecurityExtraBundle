<?php

namespace Bundle\JMS\SecurityExtraBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AddAfterInvocationProvidersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('security.authorization.after_invocation.manager')) {
            throw new \RuntimeException('Please import the services.xml file into your config.');
        }

        $providers = array_map(function($id) {
            return new Reference($id);
        }, array_keys($container->findTaggedServiceIds('security.after_invocation.provider')));

        $container
            ->getDefintion('security.authorization.after_invocation.manager')
            ->setArguments(array($providers))
        ;
    }
}