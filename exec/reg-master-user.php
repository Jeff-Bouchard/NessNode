<?php
require 'utils/autoload.php';
require 'utils/format.php';

use \modules\ness\Privateness;
use \modules\ness\lib\StorageJson;
use \modules\ness\lib\ness as ness;

ini_set('display_errors', 'yes');
error_reporting(E_ALL);


if ($argc == 2) {
    $userkey_file = $argv[1];

    $config = require __DIR__ . '/../config/ness.php';
    $node_config = require __DIR__ . '/../config/node.php';

    ness::$host = $config['host'];
    ness::$port = $config['port'];
    ness::$wallet_id = $config['wallet_id'];
    ness::$password = $config['password'];

    if (!file_exists($userkey_file)) {
        formatPrintLn(['red'], "File $userkey_file does not exist");
        exit(1);
    } else {
        $userdata = json_decode(file_get_contents($userkey_file), true);
    }

    $users_config_file = posix_getpwuid(getmyuid())['dir'] . "/.ness/data/users.json";
    $users_data = [];

    if (file_exists($users_config_file)) {
        $users_data = json_decode(file_get_contents($users_config_file), true);
    }

    $ness = new ness();
    $addr = $ness->createAddr();
    $addr = $addr['addresses'][0];
    $shadowname = md5($userdata['username'] . "+$node_config[url]+$node_config[nonce]+$node_config[private]:" . time());

    $users_data[$userdata['username']] = [
        'addr' => $addr,
        'shadowname' => $shadowname
    ];

    file_put_contents($users_config_file, json_encode($users_data, JSON_PRETTY_PRINT));

    formatPrintLn(['green', 'b'], 'Master user created and registered in ~/.ness/data/users.json');
} else {
    formatPrintLn(['green', 'b'], 'Usage: ');
    formatPrintLn(['green'], 'php reg-master-user.php user.key.json');
}