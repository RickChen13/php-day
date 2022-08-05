<?php

declare(strict_types=1);

if (!\class_exists('Env')) {
    require __DIR__ . '/Env.php';
}

if (!function_exists('microtime_type')) {
    /**
     * 获取时间戳
     *
     * @param string $type s (秒) / ms (毫秒) / us (微秒)
     * @return string
     */
    function microtime_type($type = 'ms'): string
    {
        list($usec, $sec) = explode(" ", microtime());
        switch ($type) {
                //秒
            case 's':
                $result = $sec;
                break;
            case 'ms':
                $result = sprintf('%.0f', (floatval($usec) + floatval($sec)) * 1000);
                break;
            case 'us':
                $result = sprintf('%.0f', (floatval($usec) + floatval($sec)) * 1000000);
                break;
            default:
                $result = $sec;
        }
        return $result;
    }
}

if (!function_exists('get_func_run_time')) {
    /**
     * 获取函数执行时间
     *
     * @param callable $func
     * @param array $args
     * @param mixed $result
     * @param string $type
     * @return string
     */
    function get_func_run_time(callable $func, $args = [], &$result = null, $type = "us")
    {
        $start = microtime_type($type);
        $result = call_user_func_array($func, $args);
        $end = microtime_type($type);
        return $end - $start;
    }
}

if (!function_exists('env')) {
    /**
     * 获取环境变量值
     * @access public
     * @param string $name    环境变量名
     * @param mixed  $default 默认值
     * @return mixed
     */
    function env(string $name = null, $default = null)
    {
        $file = "";
        if (defined('BASE_PATH')) {
            $file = BASE_PATH;
        } else {
            $file = dirname(__DIR__, 1);
        }
        $env = new Env($file . DIRECTORY_SEPARATOR . '.env');
        return $env->get($name, $default);
    }
}
