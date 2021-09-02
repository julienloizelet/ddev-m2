<?php declare(strict_types=1);

/**
 *
 * Run a specific cron job from browser (development only, do not use in production)
 * @see https://magento.stackexchange.com/a/273142/50208
 * @example : https://my.magento2.site/cronLaunch.php?job=VendorName\ModuleName\CronClass
 *
 *
 */
use Magento\Framework\App\Bootstrap;

require '../app/bootstrap.php';

if (php_sapi_name() !== 'cli' && isset($_GET['job'])) {
    define('CRONJOBCLASS', $_GET['job']);
} elseif (php_sapi_name() !== 'cli') {
    die('Please add the class of the cron job you want to execute as a job parameter (?job=Vendor\Module\Class)');
} else {
    die('Please do not use this script with CLI. You may use Magerun instead.' . PHP_EOL);
}

class CronRunner extends \Magento\Framework\App\Http
    implements \Magento\Framework\AppInterface
{

    public function __construct(
        \Magento\Framework\App\State $state,\Magento\Framework\App\Response\Http $response)
    {
        $this->_response = $response;
        $state->setAreaCode('adminhtml');
    }

    function launch()
    {
        $cron = \Magento\Framework\App\ObjectManager::getInstance()
            ->create(CRONJOBCLASS);

        $cron->execute();
        return $this->_response;
    }
}

$bootstrap = \Magento\Framework\App\Bootstrap::create(BP, $_SERVER);
$app = $bootstrap->createApplication('CronRunner');
$bootstrap->run($app);
