Enm Shopware SDK Bundle
=======================
A symfony integration for [leadcommerce/shopware-sdk](https://github.com/LeadCommerceDE/shopware-sdk).

[![Build Status](https://travis-ci.org/eosnewmedia/ShopwareSdkBundle.svg?branch=master)](https://travis-ci.org/eosnewmedia/ShopwareSdkBundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/77b8f306-eefe-45a0-8500-c5ca6a7f56a0/mini.png)](https://insight.sensiolabs.com/projects/77b8f306-eefe-45a0-8500-c5ca6a7f56a0)

## Installation

    composer require enm/shopware-sdk-bundle

In your `AppKernel`:

    /**
     * @return array
     */
    public function registerBundles()
    {
        $bundles = [
          // ...
          new \Enm\Bundle\ShopwareSdk\EnmShopwareSdkBundle,
        ];
         // ...
         
        return $bundles;
    }

## Configuration
Simply configure your shop connection over the global `config.yml`:

    enm_shopware_sdk:
        base_url: "http://your-shop.com"
        username: "test"
        api_key: "test"

## Usage

    /** @var \LeadCommerce\Shopware\SDK\ShopwareClient $shopwareClient */
    $shopwareClient = $container->get('enm.shopware.client');

## Tests

    php vendor/bin/phpunit
