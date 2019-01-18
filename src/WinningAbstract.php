<?php
/*
 * 彩票命中
 *
 * (c) wangtao <wangtao@p2peye.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Lottery;

abstract class WinningAbstract{
    static $winnings;
    /*
     * 命中计算
     * */
    public static function winning($bonus, $bet, $betMethod){}
}