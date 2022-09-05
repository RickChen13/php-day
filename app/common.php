<?php

declare(strict_types=1);

use think\facade\Db;

if (!function_exists('load_think_orm')) {

    /**
     * 加载think-orm配置
     */
    function load_think_orm()
    {
        $dbCoinfig = include BASE_PATH . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "database.php";
        Db::setConfig($dbCoinfig);
    }
}
