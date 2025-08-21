<?php

/**
 * Front controller for the Ness node web interface.
 *
 * Bootstraps the launcher and routes HTTP requests to services.
 *
 * @package NessNode\Web
 */

if (file_exists(__DIR__ . '/../debug')) {
    ini_set('display_errors', 'yes');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 'no');
    error_reporting(0);
}

require_once '../internals/Launcher.php';
require_once '../internals/lib/PathResolverHttpGet.php';

use internals\Launcher;
use internals\lib\PathResolverHttpGet;
use internals\lib\exceptions\EServiceNotFound;

$resolver = new PathResolverHttpGet();
$launcher = Launcher::getInstance($resolver);

try {
    $launcher->runServices();
} catch (EServiceNotFound $e) {
    ob_clean();
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    echo 'Service "' . $e->service . '" not found !';
}
