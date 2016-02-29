<?php

namespace FDevs\Bridge\Locale\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class JmsSerializerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('jms_serializer.metadata.file_locator')) {
            return;
        }
        $def = $container->getDefinition('jms_serializer.metadata.file_locator');
        $arg = $def->getArgument(0);
        if (isset($arg['FDevs\LocaleBundle'])) {
            unset($arg['FDevs\LocaleBundle']);
        }
        if (!isset($arg['FDevs\Locale'])) {
            $arg['FDevs\Locale'] = realpath(__DIR__.'/../../Resources/config/jms_serializer');
            $def->replaceArgument(0, $arg);
        }
    }
}
