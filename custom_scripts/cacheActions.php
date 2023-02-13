<?php
/**
 *
 * Run a specific cache action from browser (development only, do not use in production)
 *
 *
 */

use CrowdSec\Bouncer\Helper\Data as Data;
use CrowdSec\Bouncer\Model\Bouncer;
use CrowdSec\Bouncer\Constants;
use Magento\Framework\App\Response\Http as Response;

require '../app/bootstrap.php';

class CacheActionRunner extends \Magento\Framework\App\Http
    implements \Magento\Framework\AppInterface
{

    public function __construct(
        \Magento\Framework\App\State $state, \Magento\Framework\App\Response\Http $response)
    {
        $this->_response = $response;
        $state->setAreaCode('adminhtml');
    }

    function launch()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $helper = $objectManager->get(Data::class);
        $bouncer = \Magento\Framework\App\ObjectManager::getInstance()
            ->create(Bouncer::class, ['configs' => $helper->getBouncerConfigs(), 'helper' => $helper]);

        if (isset($_GET['action']) && in_array($_GET['action'], ['refresh', 'clear', 'prune', 'captcha-phrase'])) {
            $action = $_GET['action'];
            $result = "<h1>Cache action has been done: $action</h1>";

            switch ($action) {
                case 'refresh':
                    $bouncer->refreshBlocklistCache();
                    break;
                case 'clear':
                    $bouncer->clearCache();
                    break;
                case 'prune':
                    $bouncer->pruneCache();
                    break;
                case 'captcha-phrase':
                    if (!isset($_GET['ip'])) {
                        exit('You must pass an "ip" param to get the associated captcha phrase' . \PHP_EOL);
                    }
                    $ip = $_GET['ip'];
                    $cache = $bouncer->getRemediationEngine()->getCacheStorage();
                    $cacheKey = $cache->getCacheKey(Constants::CACHE_TAG_CAPTCHA, $ip);
                    $item = $cache->getItem($cacheKey);
                    $result = "<h1>No captcha for this IP: $ip</h1>";
                    if ($item->isHit()) {
                        $cached = $item->get();
                        $phrase =
                            $cached['phrase_to_guess'] ?? "No phrase to guess for this captcha (already resolved ?)";
                        $result = "<h1>$phrase</h1>";
                    }
                    break;
                default:
                    throw new Exception("Unknown cache action type:$action");
            }

            $response = $objectManager->get(Response::class);
            $body = "
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'/>
    <title>Cache action: $action</title>
</head>

<body>
    $result
</body>
</html>
";
            $response->setBody($body);

            return $response;
        } else {
            exit('You must pass an "action" param (refresh, clear or prune)' . \PHP_EOL);
        }
    }
}

$bootstrap = \Magento\Framework\App\Bootstrap::create(BP, $_SERVER);
$app = $bootstrap->createApplication('CacheActionRunner');
$bootstrap->run($app);
