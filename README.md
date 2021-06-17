# Magento 2 Bulk Stock Action

Custom module for Bulk Stock update from CLD To magento 2

### Installation

update `composer.json` add:

```
        {
            "type": "vcs",
            "url": "https://github.com/dsonnet/magento2bulkstock.git",
            "branch": "master"
        },

```

to `repositories` key

finally should look ~like:

```
        {
            "type": "composer",
            "url": "https://repo.magento.com/"
        },
        {
            "type": "vcs",
            "url": "https://github.com/Smartoys/AkeneoConnectorFileCollection.git",
            "branch": "master"
        },
        {
            "type": "vcs",
            "url": "https://github.com/dsonnet/magento2bulkstock.git",
            "branch": "master"
        },
        {
            "type": "composer",
            "url": "https://packagist.org"
        },

```

execute 

```composer require "smartoys/bulk-product-update @dev"```

run

```bin/magento setup:upgrade```

then

```bin/magento setup:di:compile```
