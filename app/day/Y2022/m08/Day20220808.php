<?php

declare(strict_types=1);

namespace app\day\Y2022\m08;

class Day20220808
{
    public static $dayTime = 86400;
    /**
     * 入口函数
     *
     * @return void
     */
    public function run()
    {
        $time = 1641016345;
        echo date("上个月最后一天：Y-m-d", $this->getLastDayOfLastMonth($time)), PHP_EOL;
        echo date("本月第一天：Y-m-d", $this->getFristOfThisMonth($time)), PHP_EOL;
        echo date("下个月第一天：Y-m-d", $this->getFristDayOfNetMonth($time)), PHP_EOL;
        echo date("本周第一天(星期一)：Y-m-d", $this->getFristDayOfThisWeek($time)), PHP_EOL;
        echo date("本周最后一天(星期天)：Y-m-d", $this->getLastDayOfThisWeek($time)), PHP_EOL;
    }

    /**
     * 获取上个月最后一天
     *
     * @param integer $time
     * @return int
     * @tag 日期 获取上个月最后一天
     */
    public function getLastDayOfLastMonth(int $time)
    {
        $month = date("m", $time);
        $year = date("Y", $time);
        $result = mktime(0, 0, 0, (int)$month, 0, (int)$year);
        return $result;
    }

    /**
     * 获取本月第一天
     *
     * @param int $time
     * @return int
     * @tag 日期 获取本月第一天
     */
    public function getFristOfThisMonth(int $time)
    {
        $month = date("m", $time);
        $year = date("Y", $time);
        $result = mktime(0, 0, 0, (int)$month, 1, (int)$year);
        return $result;
    }

    /**
     * 获取下个月第一天
     *
     * @param int $time
     * @return int
     * @tag 日期 获取下个月第一天
     */
    function getFristDayOfNetMonth(int $time)
    {
        $month = date("m", $time);
        $year = date("Y", $time);
        $result = mktime(0, 0, 0, (int)$month + 1, 1, (int)$year);
        return $result;
    }

    /**
     * 获取本周第一天(星期一)
     *
     * @param int $time
     * @return int
     * @tag 日期 获取本周第一天(星期一)
     */
    public function getFristDayOfThisWeek(int $time)
    {
        $week = date("w", $time);
        $week = $week === "0" ? "6" : $week - 1;
        $result = $time - self::$dayTime *  (int)$week;
        return $result;
    }

    /**
     * 获取本周最后一天(星期天)
     *
     * @param int $time
     * @return int
     * @tag 日期 获取本周最后一天(星期天)
     */
    public function getLastDayOfThisWeek(int $time)
    {
        $result = $time;
        $week = date("w", $time);
        if ($week != "0") {
            $result = $time + self::$dayTime * (7 - (int)$week);
        }
        return $result;
    }
}
