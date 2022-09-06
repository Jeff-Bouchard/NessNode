<?php

return [
    'info' => ['\services\node\controllers\Node', 'info'],
    'nodes' => ['\services\node\controllers\Node', 'nodes'],
    'services' => ['\services\node\controllers\Node', 'services'],
    'man' => ['\services\node\controllers\Node', 'man'],
    'pub' => ['\services\node\controllers\Node', 'pub'],
    'verify' => ['\services\node\controllers\Node', 'verify'],
    'slots' => ['\services\node\controllers\Node', 'slots'],
    'test/auth' => ['\services\node\controllers\Node', 'testAuthTwoWay'],
    'test/auth/([^/]+)/([^/]+)' => ['\services\node\controllers\Node', 'testAuthId'],
    'test/auth-shadow' => ['\services\node\controllers\Node', 'testAuthShadowTwoWay'],
    'test/auth-shadow/([^/]+)/([^/]+)' => ['\services\node\controllers\Node', 'testAuthShadowId'],
    '' => ['\services\node\controllers\Node', 'man'],
    'join' => ['\services\node\controllers\Node', 'join'], // TODO ...
    'joined' => ['\services\node\controllers\Node', 'joined'], // TODO ...
    'balance' => ['\services\node\controllers\Node', 'balance'], // TODO ...
    'userinfo' => ['\services\node\controllers\Node', 'userinfo'], // TODO ...
    'withdraw' => ['\services\node\controllers\Node', 'Withdraw']
];