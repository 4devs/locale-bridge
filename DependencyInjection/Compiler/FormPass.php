<?php

namespace FDevs\Bridge\Locale\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FormPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->has('twig.loader.filesystem')) {
            $container->getDefinition('twig.loader.filesystem')->addMethodCall('addPath', [realpath(__DIR__.'/../../Resources/views'), 'FDevsLocale']);
        }

        if ($container->hasParameter('twig.form.resources')) {
            $template = '@FDevsLocale/Form/fields.html.twig';
            $resources = $container->getParameter('twig.form.resources');
            if (!in_array($template, $resources)) {
                $resources[] = $template;
                $container->setParameter('twig.form.resources', $resources);
            }
        }
    }
}
