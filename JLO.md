# Notes personnelles

## Problèmes à l'installation


En suivant le quickstart Magento 2 disponible ici : https://ddev.readthedocs.io/en/stable/users/cli-usage/#magento-2-quickstart
j'ai eu une erreur `The default website isn't defined. Set the website and try again.  
` lors de l'étape d'insatllation de la base de donnée : `bin/magento setup:install --base-url...`

Voir ici : https://magento.stackexchange.com/q/328568/50208

En rajoutant `--cleanup-database`, ça passe au bout de 2 fois.


## Debug Varnish

- pour la config dans Magento :

    - Access list : 172.21.0.8,172.21.0.6 (`docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' ddev-ddev-magento2-web`)
    - Backend host : web  
    - Backend port : 80
    
Puis "export VCL for Varnish 6".

- j'ai enlevé la partie 


    .probe = {
    .url = "/pub/health_check.php";
    .timeout = 2s;
    .interval = 5s;
    .window = 10;
    .threshold = 5;
    }

du default.vcl car je pense que le chemin `/pub/health_check.php` n'est pas accessible depuis le container varnish. 
(voir pour rajouter un volume)


- Pour débugguer le purge, je me suis rentré dans le container `docker exec -ti ddev-ddev-magento2-varnish  sh` et 
  ensuite `varnishlog -g request -q 'ReqMethod eq "PURGE"'`
  

- Pour voir que tout est OK : `curl -I -v --location-trusted  https://ddev-magento2.ddev.site/
  `
  voir ici : https://devdocs.magento.com/guides/v2.4/config-guide/varnish/config-varnish-final.html

## Utiliser ces propres modules en local avec composer

- créer un dossier `my-own-modules` à la racine des sources Magento 2
- Cloner les sources de son module dans un dossier `module-name`


- Relancer le projet `ddev stop & ddev start`
- Rajouter le repository de type "path" dans composer 

      ddev composer config repositories.some-name-for-this-module-path-repo path ./my-own-modules/module-name/ 

Par exemple `some-name-for-this-module-path-repo = okaeli-roundprices-module`

- Enfin, en supposant que le nom du package du module (defini dans son `composer.json`) est `vendorName/moduleName` 
  il faut lancer

      ddev composer require vendorName/moduleName

## Mémo

- url de l'admin : https://ddev-magento2.ddev.site/admin_y312l0

## Crowdsec

    ddev exec --service crowdsec cscli decisions add --ip 172.17.0.1 --duration 4h --type ban

    ddev exec --service crowdsec cscli decisions delete --all

    ddev exec -s crowdsec cscli bouncers add magento2-bouncer


## Redis

    ddev exec --service redis sh

    redis-cli

    CONFIG GET databases

    INFO keyspace

## Memcached

@see https://lzone.de/cheat-sheet/memcached

    docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' ddev-ddev-magento2-memcached

    telnet 172.21.0.5 11211 

    stats

    stats items


## EQP coding standard 


### PHPCS
```
 ddev exec php ./vendor/bin/phpcs  --standard=Magento2 --runtime-set ignore_errors_on_exit 1 --runtime-set ignore_warnings_on_exit 1 /var/www/html/my-own-modules/crowdsec-bouncer
```

### PHPCBF
```
ddev exec php ./vendor/bin/phpcbf  --standard=Magento2 --runtime-set ignore_errors_on_exit 1 --runtime-set ignore_warnings_on_exit 1 /var/www/html/my-own-modules/crowdsec-bouncer
```

## Mess detector

    ddev exec php ./vendor/bin/phpmd  my-own-modules/crowdsec-bouncer text dev/tests/static/testsuite/Magento/Test/Php/_files/phpmd/ruleset.xml

## Unit tests

To launch unit test, run the following command from your Magento® 2 root directory :

    ddev exec php vendor/bin/phpunit -c dev/tests/unit/phpunit.xml.dist /var/www/html/vendor/crowdsec/magento2-bouncer/Test/Unit

### copy/paste validation

To run copy paste detector on the full project :

    ddev exec php -d memory_limit=-1 vendor/bin/phpcpd --log-pmd 
'dev/tests/static/report/phpcpd_report.xml' --names-exclude "*Test.php"  --min-lines 13  --exclude 'generated/code' 
--exclude 'dev' /var/www/html 
`

## Dockerized Magento 2 and Phpstorm


To generate xsd schema mapping, go to the path of Magento 2 installation directory

    cd /some/path/to/the/m2/sources/

And run the following commmand :

    ddev exec php bin/magento dev:urn-catalog:generate .idea/misc.xml 

Maybe you should have to delete first the `.idea/misc.xml`. 


## Mage 2 TV clean Cache :

ddev composer require --dev mage2tv/magento-cache-clean

ddev exec php /var/www/html/vendor/mage2tv/magento-cache-clean/bin/generate-cache-clean-config.php

ddev exec node  /var/www/html/vendor/mage2tv/magento-cache-clean/bin/cache-clean.js --watch


todo : You should add some alias in your `.bash_aliases` for example :

    cache-clean.js () {
       ddev exec php /var/www/html/vendor/mage2tv/magento-cache-clean/bin/generate-cache-clean-config.php
       ddev exec node  /var/www/html/vendor/mage2tv/magento-cache-clean/bin/cache-clean.js "$@"
    }
With this alias, you just have to run `cache-clean.js --watch` in your ddev Magento 2 folder.


## PhpStorm

### Code Sniffer Magento 2 (Local)

    Settings -> PHP -> Quality Tools : Php code Sniffer : Local /home/julien/workspace/ddev-magento2/vendor/bin/phpcs

    Settings ->  Editor -> Inspection -> PHP -> Quality Tools -> Php code Sniffer validation -> Custom -> Magento 2

Peut être faut il commenter une ligne d'erreur composer dans vendor/composer/platform_check.php
car on travaille en local et que le composer est celui du container docker


### X-debug

    ddev xdebug on

    Menu -> Start listening for PHP Debug Connections

    Settings -> PHP -> Servers Configurer le serveur avec le path qui pointe vers /var/www/html
