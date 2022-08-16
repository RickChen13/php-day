<?php

declare(strict_types=1);

namespace app\day\Y2022\m08;

class Day20220816
{
    /**
     * 入口函数
     *
     * @return void
     */
    public function run()
    {
        $arr0 = [1, 2, 3, 4];
        $arr1 = [5, 6, 7, 8];
        $arr2 = [9, 10, 11, 12];
        $result = $this->concat($arr0, $arr1, $arr2);
        var_dump($result);
    }

    /**
     * 数组拼接
     *
     * @param array $arr0
     * @param array $arr1
     * @param array ...$arrs
     * @return array
     * @tag 数组 数组拼接 js的concat函数实现
     */
    public function concat($arr0, $arr1, ...$arrs)
    {
        array_walk($arr1, function ($v) use (&$arr0) {
            $arr0[] = $v;
        });
        foreach ($arrs as $arr) {
            array_walk($arr, function ($v) use (&$arr0) {
                $arr0[] = $v;
            });
        }
        return $arr0;
    }
}
