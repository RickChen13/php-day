<?php

declare(strict_types=1);

namespace app\day\Y2022\m08;

class Day20220830
{
    /**
     * 入口函数
     *
     * @return void
     */
    public function run()
    {
        $arr = [3, 1, 2, 4];
        $newArr = $this->QuickSort($arr);
        var_dump($newArr);
    }

    /**
     * 二分插入排序
     *
     * @param array $arr
     * @return array
     * @tag 排序
     */
    public function BinaryInsertionSort(array $arr)
    {
        $len = count($arr);
        if ($len < 2) {
            return $arr;
        } else {
            for ($i = 1; $i < $len; $i++) {
                $left = 0;
                $right = $i - 1;
                $temp = $arr[$i];
                while ($left <= $right) {
                    $mid = intval(($left + $right) / 2);
                    if ($temp < $arr[$mid]) {
                        $right = $mid - 1;
                    } else {
                        $left = $mid + 1;
                    }
                }
                for ($j = $i - 1; $j >= $left; $j--) {
                    $arr[$j + 1] =  $arr[$j];
                }
                if ($left != $i) {
                    $arr[$left] = $temp;
                }
            }
        }
        return $arr;
    }

    /**
     * 快速排序
     *
     * @param array $arr
     * @return arr
     * @tag 排序
     */
    public function QuickSort(array $arr)
    {
        //递归出口:递归至数组长度为1，则返回数组
        $length = count($arr);
        if ($length <= 1) return $arr;

        //数组元素有多个,则定义两个空数组
        $left = array();
        $right = array();

        //使用for循环遍历数组
        for ($i = 1; $i < $length; $i++) {
            $value = $arr[0]; //把 第一个元素 当做 比较对象

            if ($arr[$i] < $value) {
                $left[] = $arr[$i];    //小于 比较对象放入 $left 数组
            } else {
                $right[] = $arr[$i];    //大于 比较对象放入 $right 数组
            }
        }

        //不断递归 $left、$right数组知道数组长度为1
        $left = $this->QuickSort($left);
        $right = $this->QuickSort($right);


        //将所有的结果合并
        return array_merge($left, [$value], $right);
    }
}
