<?php

namespace Enm\Bundle\ShopwareSdk\Tests;

use Enm\Bundle\ShopwareSdk\DependencyInjection\EnmShopwareSdkExtension;
use LeadCommerce\Shopware\SDK\ShopwareClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class ShopwareBundleTest extends TestCase
{
    public function testShopwareExtension()
    {
        $builder   = new ContainerBuilder();
        $extension = new EnmShopwareSdkExtension();
        $extension->load([
          'enm_shopware_sdk' => [
            'base_url' => 'http://example.com',
            'username' => 'test',
            'api_key'  => 'test',
          ],
        ], $builder);
        
        self::assertInstanceOf(
          ShopwareClient::class,
          $builder->get('enm.shopware.client')
        );
    }
    
    /**
     * @expectedException \Exception
     */
    public function testShopwareConfigurationInvalidBaseUrl()
    {
        $builder   = new ContainerBuilder();
        $extension = new EnmShopwareSdkExtension();
        $extension->load([
          'enm_shopware_sdk' => [
            'base_url' => '',
            'username' => 'test',
            'api_key'  => 'test',
          ],
        ], $builder);
    }
    
    /**
     * @expectedException \Exception
     */
    public function testShopwareConfigurationInvalidUsername()
    {
        $builder   = new ContainerBuilder();
        $extension = new EnmShopwareSdkExtension();
        $extension->load([
          'enm_shopware_sdk' => [
            'base_url' => 'http://example.com',
            'username' => '',
            'api_key'  => 'test',
          ],
        ], $builder);
    }
    
    /**
     * @expectedException \Exception
     */
    public function testShopwareConfigurationInvalidApiKey()
    {
        $builder   = new ContainerBuilder();
        $extension = new EnmShopwareSdkExtension();
        $extension->load([
          'enm_shopware_sdk' => [
            'base_url' => 'http://example.com',
            'username' => 'test',
            'api_key'  => '',
          ],
        ], $builder);
    }
}
