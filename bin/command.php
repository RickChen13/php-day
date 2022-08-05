<?php

declare(strict_types=1);

ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');
ini_set('memory_limit', '1G');
error_reporting(E_ALL);
date_default_timezone_set('Asia/Shanghai');
!defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 1));
require BASE_PATH . '/vendor/autoload.php';

if (extension_loaded("swoole")) {
    \Swoole\Coroutine\run(function () use ($argc, $argv) {
        (new \app\command\Command($argc, $argv))->run();
    });
} else {
    (new \app\command\Command($argc, $argv))->run();
}
