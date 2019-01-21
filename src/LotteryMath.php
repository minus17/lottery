<?php
/*
 * 彩票命中需要的数据公式
 *
 * (c) wangtao <wangtao@p2peye.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lottery;

class LotteryMath{
    /*
     * 计算数组的笛卡尔积
     * */
    public static function cartesian($set)
    {
        if (!$set) {
            return array(array());
        }
        $subset = array_shift($set);
        $cartesianSubset = self::cartesian($set);
        $result = array();
        foreach ($subset as $value) {
            foreach ($cartesianSubset as $p) {
                array_unshift($p, $value);
                $result[] = $p;
            }
        }
        return $result;
    }

    /**
     * 阶乘
     */
    public static function factorial($n) {
        //array_product 计算并返回数组的乘积
        //range 创建一个包含指定范围的元素的数组
        return array_product(range(1, $n));
    }

    /**
     * 排列 n >= m  m,n均为自然数
     */
    public static function A($n, $m) {
        if($n == $m){
            return self::factorial($n);
        }
        return self::factorial($n)/self::factorial($n-$m);
    }

    /**
     * 组合
     */
    public static function C($n, $m) {
        if($n < $m){
            return false;
        }
        if($m == 0 || $n == $m){
            return 1;
        }
        return self::A($n, $m)/self::factorial($m);
    }
}