<?php

// JSON API to run specific whitelisted PHP scripts from ../
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
        exit;
    }

    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input)) {
        throw new Exception('Invalid JSON body');
    }

    $script = $input['script'] ?? '';
    $args = $input['args'] ?? [];

    if (!is_string($script) || !is_array($args)) {
        throw new Exception('Invalid parameters');
    }

    // Hard whitelist of executable scripts (relative to ../)
    $whitelist = [
        'self-test.php',
        'make-config.php',
        'bulk_make_config.php',
        'create-user.php',
        'reg-master-user.php',
        'payment-test.php',
        'users.php',
        'test.php',
    ];

    if (!in_array($script, $whitelist, true)) {
        throw new Exception('Script not allowed');
    }

    // Resolve path and ensure it exists
    $execDir = realpath(__DIR__ . '/../');
    if ($execDir === false) {
        throw new Exception('Execution directory not found');
    }

    $target = $execDir . DIRECTORY_SEPARATOR . $script;
    if (!is_file($target)) {
        throw new Exception('Script file does not exist');
    }

    // Provide stubs for POSIX when unavailable (Windows compatibility)
    if (!function_exists('posix_getpwuid')) {
        function posix_getpwuid($uid)
        {
            $home = getenv('USERPROFILE');
            if (!$home) {
                $home = sys_get_temp_dir();
            }
            return ['dir' => $home];
        }
    }
    if (!function_exists('getmyuid')) {
        function getmyuid()
        {
            return 0;
        }
    }

    // Simulate CLI args
    $argv = array_merge([$script], array_map('strval', $args));
    $argc = count($argv);
    $GLOBALS['argv'] = $argv;
    $GLOBALS['argc'] = $argc;

    // Ensure relative includes (e.g., require 'utils/autoload.php') work as in CLI
    $oldCwd = getcwd();
    chdir($execDir);

    ob_start();
    $ok = true;
    $err = null;
    try {
        // Isolate variables to avoid leaking locals into the required script
        (function () use ($target) {
            require $target;
        })();
    } catch (Throwable $t) {
        $ok = false;
        $err = $t->getMessage() . "\n" . $t->getFile() . ':' . $t->getLine();
    } finally {
        $output = ob_get_clean();
        chdir($oldCwd);
    }

    if (!$ok) {
        echo json_encode(['ok' => false, 'error' => $err, 'output' => $output]);
        exit;
    }

    echo json_encode(['ok' => true, 'output' => $output]);
} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
