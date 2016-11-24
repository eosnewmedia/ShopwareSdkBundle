<?php
declare(strict_types = 1);

namespace Enm\Bundle\ShopwareSdk\DependencyInjection;

use Enm\ShopwareSdk\EntryPoint;
use Enm\ShopwareSdk\Http\GuzzleAdapter;
use GuzzleHttp\Client;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\SerializerBuilder;
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
        /**
         * Guzzle Client
         */
        $guzzleDefinition = new Definition(Client::class);
        $guzzleDefinition->setPublic(false);
        
        $container->setDefinition('enm.shopware.guzzle', $guzzleDefinition);
        
        /**
         * Http Client (Guzzle Adapter)
         */
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
        
        /**
         * JMS Serializer
         * The serializer bundle isn't used here because a custom naming strategy
         * only for this sdk is needed.
         */
//        $serializerDefinition = new Definition();
//        $serializerDefinition->setSynthetic(true);
//        $serializerDefinition->setPublic(false);
//        $container->setDefinition(
//          'enm.shopware.jms_serializer',
//          $serializerDefinition
//        );

        $container->register('enm.shopware.jms_serializer')->setSynthetic('true');

        $serializer = SerializerBuilder::create()
                                       ->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy())
                                       ->build();
        
        $container->set('enm.shopware.jms_serializer', $serializer);
        
        /**
         * Entry Point
         */
        $entryPointDefinition = new Definition(
          EntryPoint::class,
          [
            new Reference('enm.shopware.http_client'),
          ]
        );
        $entryPointDefinition->addMethodCall(
          'addDefaultSerializers',
          [
            new Reference('enm.shopware.jms_serializer'),
          ]
        );
        $entryPointDefinition->addMethodCall(
          'addDefaultDeserializers',
          [
            new Reference('enm.shopware.jms_serializer'),
          ]
        );
        
        $container->setDefinition(
          'enm.shopware.entry_point',
          $entryPointDefinition
        );
    }
}
