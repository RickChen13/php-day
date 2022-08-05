<?php

declare(strict_types=1);

namespace app\common\helper;

class Math
{
    /**
     * 排列(A)
     *
     * @param integer $x 上标
     * @param integer $y 下标
     * @return string
     */
    public function arrange(int $x, int $y): string
    {
        if ($x > $y) {
            $result = 0;
        } else {
            $result = 1;
            for ($i = 0; $i < $x; $i++) {
                $result *= ($y - $i);
            }
        }
        return number_format($result, 0, '', '');
    }

    /**
     * 组合(C)
     *
     * @param integer $x 上标
     * @param integer $y 下标
     * @return string
     */
    public function combination(int $x, int $y): string
    {
        if ($x > $y) {
            $result = 0;
        } else {
            $result = (int)$this->arrange($x, $y);
            $result /= (int)$this->factorial($x);
        }
        return number_format($result, 0, '', '');
    }

    /**
     * 阶乘
     *
     * @param int $x
     * @return string
     */
    public function factorial(int $x): string
    {
        if ($x > 1) {
            $result = $x * (int)$this->factorial($x - 1);
        } else {
            $result = $x;
        }
        return number_format($result, 0, '', '');
    }
}
