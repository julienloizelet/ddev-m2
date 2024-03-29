# DDEV stack for Magento 2

[![Version](https://img.shields.io/github/v/release/julienloizelet/ddev-m2?include_prereleases)](https://github.com/julienloizelet/ddev-m2/releases)
[![Magento 2 Installation](https://github.com/julienloizelet/ddev-m2/actions/workflows/installation.yml/badge.svg)](https://github.com/julienloizelet/ddev-m2/actions/workflows/installation.yml)



The purpose of this repo is to share my Magento 2 [DDEV](https://ddev.readthedocs.io/en/stable/) stack.

## This project is unmaintained

This project is officially marked as unmaintained, since I am now using DDEV add-ons like: 

- [My tools add-on](https://github.com/julienloizelet/ddev-tools)
- [Redis add-on](https://github.com/ddev/ddev-redis)
- [Memcached add-on](https://github.com/ddev/ddev-memcached)
- [Elasticsearch add-on](https://github.com/ddev/ddev-elasticsearch)
- [Varnish add-on](https://github.com/ddev/ddev-varnish)

If you want to see how ddev add-ons can be used to test a Magento 2 module, take a look to my [GitHub action](https://github.com/julienloizelet/magento2-ddev-installation/) and their associated [workflow tests](https://github.com/julienloizelet/magento2-ddev-installation/tree/main/.github/workflows).


<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Quick start](#quick-start)
  - [DDEV installation](#ddev-installation)
  - [Prepare DDEV Magento 2 environment](#prepare-ddev-magento-2-environment)
  - [Magento 2 installation](#magento-2-installation)
  - [Set up Magento 2](#set-up-magento-2)
  - [Configure Magento 2 for local development](#configure-magento-2-for-local-development)
- [Usage](#usage)
  - [Test your own module](#test-your-own-module)
    - [Static tests](#static-tests)
    - [Unit tests](#unit-tests)
  - [Cron](#cron)
  - [Varnish](#varnish)
    - [Varnish debug](#varnish-debug)
  - [Working with Mage2TV clean-cache](#working-with-mage2tv-clean-cache)
- [License](#license)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Quick start

_We will suppose that you want to test on a Magento 2.4.3 instance. Change the version number if you prefer another
release._

### DDEV installation

This project is fully compatible with DDEV 1.21.6, and it is recommended to use this specific version.
For the DDEV installation, please follow the [official instructions](https://ddev.readthedocs.io/en/stable/#installation).

### Prepare DDEV Magento 2 environment

The structure of the project will look like below.

```
m2-sources
│   
│ (Magento 2 sources installed with composer)    
│
└───.ddev
    │   
    │ (Cloned sources of this repo)
```

- Create an empty folder that will contain all necessary sources:
```
mkdir m2-sources
```
- Create an empty `.ddev` folder for DDEV and clone our pre-configured DDEV repo:

```
mkdir m2-sources/.ddev && cd m2-sources/.ddev && git clone git@github.com:julienloizelet/ddev-m2.git ./
```
- Copy some configurations file:

```
cp .ddev/config_overrides/config.m243.yaml .ddev/config.m243.yaml
```
- Launch DDEV

```
cd .ddev && ddev start
```
This should take some times on the first launch as this will download all necessary docker images.


### Magento 2 installation
You will need your Magento 2 credentials to install the source code.

     ddev composer create --repository=https://repo.magento.com/ magento/project-community-edition:2.4.3


### Set up Magento 2

     ddev magento setup:install \
                           --base-url=https://m243.ddev.site \
                           --db-host=db \
                           --db-name=db \
                           --db-user=db \
                           --db-password=db \
                           --backend-frontname=admin \
                           --admin-firstname=admin \
                           --admin-lastname=admin \
                           --admin-email=admin@admin.com \
                           --admin-user=admin \
                           --admin-password=admin123 \
                           --language=en_US \
                           --currency=USD \
                           --timezone=America/Chicago \
                           --use-rewrites=1 \
                           --elasticsearch-host=elasticsearch

This should take ages.

### Configure Magento 2 for local development

    ddev magento config:set admin/security/password_is_forced 0
    ddev magento config:set admin/security/password_lifetime 0
    ddev magento module:disable Magento_TwoFactorAuth
    ddev magento indexer:reindex
    ddev magento c:c


## Usage

### Test your own module

There are at least two ways to handle the source code of a custom Magento 2 module:
- use the `app/code` folder
- use composer and its `vendor` folder


Please read [this post](https://gist.github.com/Vinai/a94f2500cc5694a258620bbd30692b87) from Vinai Kopp to have an 
idea of the pros and cons of each approach.

As I mainly develop extension as an "extension vendor" developer (and not a "merchant" developer), I chose the 
composer way. Furthermore, as explained in this [Yireo article](https://www.yireo.com/blog/2019-05-10-local-composer-development-with-magento2) (see the "My approach: Use composer paths" part), I am 
using a composer local path that I will call `my-own-modules/yourVendorName-yourModuleName` and I put my module 
sources inside it.

Thus, the final structure of the project will look like below.

```
m2-sources
│   
│ (Magento 2 sources installed with composer)    
│
└───.ddev
│   │   
│   │ (Cloned sources of this repo)
│   
└───my-own-modules
    │   
    │
    └───yourVendorName-yourModuleName
       │   
       │ (Sources of a module)
         
```

You can choose the better way for you, depending on your needs. But if you make the same choice as me, here is what 
you can do:


```
cd m2-sources
mkdir -p my-own-modules/yourVendorName-yourModuleName
cd my-own-modules/yourVendorName-yourModuleName 
git clone git@github.com:yourGithubName/yourGithubModule.git ./
ddev composer config repositories.yourVendorName-yourModuleName path my-own-modules/yourVendorName-yourModuleName/
ddev composer require yourComposerModuleName:@dev
ddev magento module:enable yourVendorName_yourModuleName
ddev magento setup:upgrade
ddev magento cache:flush
```

#### Static tests

During development, you can run some static php tools to ensure quality code:

- PHP Code Sniffer: `ddev phpcs my-own-modules/yourVendorName-yourModuleName`
- PHP Mess Detector: `ddev phpmd my-own-modules/yourVendorName-yourModuleName`
- PHP Stan: `ddev phpstan my-own-modules/yourVendorName-yourModuleName`

#### Unit tests

You can also check unit tests: `ddev phpunit my-own-modules/yourVendorName-yourModuleName/Test/Unit`

### Cron

If you want to simulate Magento 2 cron, run the following command in
a new terminal:

     ddev cron

To stop the cron, you have to close your terminal.

You should find a `var/log/magento.cron.log` for debug.

### Varnish

First, you should configure your Magento 2 instance to use Varnish as cache: 

```
ddev magento config:set system/full_page_cache/caching_application 2
```

Then, you can add specific files for Varnish and restart:

```
cp .ddev/additional_docker_compose/docker-compose.varnish.yaml .ddev/docker-compose.varnish.yaml
cp .ddev/custom_files/default.vcl .ddev/varnish/default.vcl
ddev restart
```

Finally, we need to change the ACL part for purge process:

```
ddev replace-acl $(ddev find-ip ddev-router)
ddev reload-vcl
```


For information, here are the differences between the back office generated `default.vcl` and the `default.vcl` I use: 

- I changed the probe url from `"/pub/health_check.php"` to `"/health_check.php"` as explained in the
[official documentation](https://experienceleague.adobe.com/docs/commerce-operations/configuration-guide/cache/config-varnish-advanced.html?lang=en):

```
 .probe = {
    .url = "/health_check.php";
    .timeout = 2s;
    .interval = 5s;
    .window = 10;
    .threshold = 5;
    }
```


- I added this part for Marketplace EQP Varnish test simulation as explained in the [official documentation](https://devdocs.magento.com/marketplace/sellers/installation-and-varnish-tests.html#additional-magento-configuration):

```
if (resp.http.x-varnish ~ " ") {
           set resp.http.X-EQP-Cache = "HIT";
       } else {
           set resp.http.X-EQP-Cache = "MISS";
}
```


#### Varnish debug

To see if purge works, you can do : 

```
ddev exec -s varnish varnishlog -g request -q \'ReqMethod eq "PURGE"\'
```

And then, from another terminal, flush the cache :

```
ddev magento cache:flush
```

You should see in the log the following content: 

```
VCL_call       RECV
VCL_acl        MATCH purge "your-ddev-router-ip"
VCL_return     synth
VCL_call       HASH
VCL_return     lookup
RespProtocol   HTTP/1.1
RespStatus     200
RespReason     Purged
```

### Working with Mage2TV clean-cache

The Mage2TV clean-cache is a developer tool that automatically cleans the cache when necessary.

```

# Install
ddev composer require --dev mage2tv/magento-cache-clean
# In your project create the var/cache-clean-config.json by running:
ddev exec php /var/www/html/vendor/mage2tv/magento-cache-clean/bin/generate-cache-clean-config.php
# Run to start watching
ddev exec node /var/www/html/vendor/mage2tv/magento-cache-clean/bin/cache-clean.js --watch
```

You should add some alias in your `.bash_aliases` for example :

```
cache-clean.js () {
ddev exec php /var/www/html/vendor/mage2tv/magento-cache-clean/bin/generate-cache-clean-config.php
ddev exec node /var/www/html/vendor/mage2tv/magento-cache-clean/bin/cache-clean.js "$@"
}
```
With this alias, you just have to run `cache-clean.js --watch` in your Magento 2 folder.

## License

[MIT](LICENSE)
