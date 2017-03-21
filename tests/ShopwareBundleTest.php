<?php
declare(strict_types = 1);

namespace Enm\Bundle\ShopwareSdk\Tests;

use Enm\Bundle\ShopwareSdk\DependencyInjection\EnmShopwareSdkExtension;
use Enm\ShopwareSdk\EntryPointInterface;
use JMS\Serializer\SerializerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class ShopwareBundleTest extends TestCase
{
    public function testShopwareExtension()
    {
        $builder = new ContainerBuilder();
        $builder->set(
          'jms_serializer.serializer',
          $this->createMock(SerializerInterface::class)
        );
        
        $extension = new EnmShopwareSdkExtension();
        $extension->load([
          'enm_shopware_sdk' => [
            'base_url' => 'http://example.com',
            'username' => 'test',
            'api_key'  => 'test',
          ],
        ], $builder);
        
        $builder->compile();
        
        self::assertInstanceOf(
          EntryPointInterface::class,
          $builder->get('enm.shopware.entry_point')
        );
    }
    
    /**
     * @expectedException \Exception
     */
    public function testShopwareConfigurationInvalidBaseUrl()
    {
        $builder = new ContainerBuilder();
        $builder->set(
          'jms_serializer.serializer',
          $this->createMock(SerializerInterface::class)
        );
        
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
        $builder = new ContainerBuilder();
        $builder->set(
          'jms_serializer.serializer',
          $this->createMock(SerializerInterface::class)
        );
        
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
        $builder = new ContainerBuilder();
        $builder->set(
          'jms_serializer.serializer',
          $this->createMock(SerializerInterface::class)
        );
        
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
