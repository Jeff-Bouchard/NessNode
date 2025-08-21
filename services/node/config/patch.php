<?php

return [
    'info' => ['\services\node\controllers\Node', 'info'],
    'nodes' => ['\services\node\controllers\Node', 'nodes'],
    'exist/(.+)' => ['\services\node\controllers\Node', 'userExists'],
    'services' => ['\services\node\controllers\Node', 'services'],
    'about' => ['\services\node\controllers\Node', 'about'],
    'pub' => ['\services\node\controllers\Node', 'pub'],
    'verify' => ['\services\node\controllers\Node', 'verify'],
    'slots' => ['\services\node\controllers\Node', 'slots'],
    'test/auth' => ['\services\node\controllers\Node', 'testAuthTwoWay'],
    'test/auth/([^/]+)/([^/]+)' => ['\services\node\controllers\Node', 'testAuthId'],
    'test/auth-shadow' => ['\services\node\controllers\Node', 'testAuthShadowTwoWay'],
    'test/auth-shadow/([^/]+)/([^/]+)' => ['\services\node\controllers\Node', 'testAuthShadowId'],
    '' => ['\services\node\controllers\Node', 'man'],
    'join' => ['\services\node\controllers\Node', 'join'],
    'joined' => ['\services\node\controllers\Node', 'joined'],
    'balance' => ['\services\node\controllers\Node', 'balance'],
    'userinfo' => ['\services\node\controllers\Node', 'userinfo'],
    'withdraw' => ['\services\node\controllers\Node', 'Withdraw']
];
