<?php

namespace Enm\Bundle\ShopwareSdk\DependencyInjection;

use LeadCommerce\Shopware\SDK\ShopwareClient;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\BadMethodCallException;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class EnmShopwareSdkExtension extends ConfigurableExtension
{
    /**
     * Configures the passed container according to the merged configuration.
     *
     * @param array $mergedConfig
     * @param ContainerBuilder $container
     *
     * @throws BadMethodCallException
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $container->setDefinition(
          'enm.shopware.client',
          new Definition(
            ShopwareClient::class,
            [
              $mergedConfig['base_url'],
              $mergedConfig['username'],
              $mergedConfig['api_key'],
            ]
          )
        );
    }
}
