# DDEV-Local stack for Magento 2

The purpose of this repo is to share my Magento 2 [DDEV-Local](https://ddev.readthedocs.io/en/stable/) stack.


<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Quick start](#quick-start)
  - [DDEV-Local installation](#ddev-local-installation)
  - [Prepare DDEV Magento 2 environment](#prepare-ddev-magento-2-environment)
  - [Magento 2 installation](#magento-2-installation)
  - [Set up Magento 2](#set-up-magento-2)
  - [Cron](#cron)
- [License](#license)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Quick start

_We will suppose that you want to test on a Magento 2.4.3 instance. Change the version number if you prefer another
release._

### DDEV-Local installation

Please follow the [official instructions](https://ddev.readthedocs.io/en/stable/#installation). On a Linux
distribution, this should be as simple as

    sudo apt-get install linuxbrew-wrapper
    brew tap drud/ddev && brew install ddev


### Prepare DDEV Magento 2 environment

The final structure of the project will look like below.

```
m2-sources
│   
│ (Magento 2 sources installed with composer)    
│
└───.ddev
│   │   
│   │ (Cloned sources of this repo)
│   
└───my-own-modules (only if you want to test some of your module(s))
    │   
    │
    └───yourVendorName-yourModuleName
       │   
       │ (Sources of a module)
         
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


## Usage

### Test your own module

```
mkdir m2-sources/my-own-modules
mkdir m2-sources/my-own-modules/yourVendorName-yourModuleName
cd m2-sources/my-own-modules/yourVendorName-yourModuleName 
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


## License

[MIT](LICENSE)
