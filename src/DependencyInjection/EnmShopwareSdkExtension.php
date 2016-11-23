<?php
declare(strict_types = 1);

namespace Enm\Bundle\ShopwareSdk\DependencyInjection;

use Enm\ShopwareSdk\EntryPoint;
use Enm\ShopwareSdk\Http\GuzzleAdapter;
use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
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
     * @throws \Exception
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $guzzleDefinition = new Definition(Client::class);
        $guzzleDefinition->setPublic(false);
        
        $container->setDefinition('enm.shopware.guzzle', $guzzleDefinition);
        
        $clientDefinition = new Definition(
          GuzzleAdapter::class,
          [
            new Reference('enm.shopware.guzzle'),
          ]
        );
        $clientDefinition->addMethodCall(
          'withConfig',
          [
            $mergedConfig['base_url'],
            $mergedConfig['username'],
            $mergedConfig['api_key'],
          ]
        );
        $clientDefinition->setPublic(false);
        
        $container->setDefinition(
          'enm.shopware.http_client',
          $clientDefinition
        );
        
        $entryPointDefinition = new Definition(
          EntryPoint::class,
          [
            new Reference('enm.shopware.http_client'),
          ]
        );
        $entryPointDefinition->addMethodCall(
          'addDefaultResponseHandlers',
          [
            new Reference('jms_serializer.serializer'),
          ]
        );
        
        $container->setDefinition(
          'enm.shopware.entry_point',
          $entryPointDefinition
        );
    }
}
