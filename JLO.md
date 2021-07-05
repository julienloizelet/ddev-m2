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
- Avoir les sources de son module dans un répertoire en dehors du projet `/path/to/specific-module`
- Rajouter un volume dans le service web (voir le fichier docker-compose.own-modules)
    
      version: '3.6'
      services:
      web:
      volumes:
      - /path/to/specific-module:/var/www/html/my-own-modules/specific-module


- Relancer le projet `ddev stop & ddev start`
- Rajouter le repository de type "path" dans composer 

      ddev composer config repositories.some-name-for-this-module-path-repo path ./my-own-modules/specific-module/ 

Par exemple `some-name-for-this-module-path-repo = okaeli-roundprices-module`

- Enfin, en supposant que le nom du package du module (defini dans son `composer.json`) est `vendorName/moduleName` 
  il faut lancer

      ddev composer require vendorName/moduleName

## Mémo

- url de l'admin : https://ddev-magento2.ddev.site/admin_y312l0

## Crowdsec

    ddev exec --service crowdsec cscli decisions add --ip 172.17.0.1 --duration 4h --type ban

    ddev exec --service crowdsec cscli decisions delete --all


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
