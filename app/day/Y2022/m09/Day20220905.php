<?php

declare(strict_types=1);

namespace app\day\Y2022\m09;

use think\facade\Db;

class Day20220905
{
    /**
     * 入口函数
     *
     * @return void
     */
    public function run()
    {
        load_think_orm();

        /* -- 创建数据库代码
        CREATE TABLE `demo` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(50) NOT NULL,
            PRIMARY KEY (`id`)
        )
        COLLATE='utf8mb4_unicode_ci'
        */

        $this->dbTest();
    }

    /**
     * 测试是否能连接数据库
     *
     * @return void
     */
    public function dbTest()
    {
        $count = Db::name("demo")->count();
        echo $count, PHP_EOL;
    }
}
