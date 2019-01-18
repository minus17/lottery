<?php
/*
 * 彩票命中接口
 *
 * (c) wangtao <wangtao@p2peye.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Lottery;

interface WinningInterface{

    /*
     * 命中计算
     * */
    public static function winning($bonus, $bet, $betMethod);
}