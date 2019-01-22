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

class LotteryHelper{
    /*
     * 第一位标识发行方：体彩、福彩
     * 第二位标识彩种
     * 第三位标识投注玩法
     * */
    public static $lotteryCats = array(
        '111' => array('Lottery\DaletouWinning', 'onePickForSingleBet'), //体彩大乐透单式
        '112' => array('Lottery\DaletouWinning', 'onePickForMultiBet'), //体彩大乐透复式
        '113' => array('Lottery\DaletouWinning', 'onePickForOptBet'), //体彩大乐透胆拖
        '121' => array('Lottery\QixingcaiWinning', 'onePickForSingleBet'), //体彩七星彩单式
        '122' => array('Lottery\QixingcaiWinning', 'onePickForMultiBet'), //体彩七星彩复式
        '131' => array('Lottery\Pailie3Winning', 'onePickForSingleBet'), //体彩排列3单式
        '132' => array('Lottery\Pailie3Winning', 'onePickForMultiBet'), //体彩排列3复式
        '141' => array('Lottery\Pailie5Winning', 'onePickForSingleBet'), //体彩排列5单式
        '142' => array('Lottery\Pailie5Winning', 'onePickForMultiBet'), //体彩排列5复式
        '211' => array('Lottery\ShuangseqiuWinning', 'onePickForSingleBet'), //福彩双色球单式
        '212' => array('Lottery\ShuangseqiuWinning', 'onePickForMultiBet'), //福彩双色球复式
        '213' => array('Lottery\ShuangseqiuWinning', 'onePickForOptBet'), //福彩双色球胆拖
        '221' => array('Lottery\Fucai3DWinning', 'onePickForSingleBet'), //福彩3D单式
        '222' => array('Lottery\Fucai3DWinning', 'onePickForSingleMultiBet'), //福彩3D单选单复式
        '223' => array('Lottery\Fucai3DWinning', 'onePickForDoubleMultiBet'), //福彩3D单选双复式
        '224' => array('Lottery\Fucai3DWinning', 'onePickForFullMultiBet'), //福彩3D单选全复式
        '225' => array('Lottery\Fucai3DWinning', 'group3PickForSingleBet'), //福彩3D组选3单式
        '226' => array('Lottery\Fucai3DWinning', 'group3PickForMultiBet'), //福彩3D组选3复式
        '227' => array('Lottery\Fucai3DWinning', 'group6PickForSingleBet'), //福彩3D组选6单式
        '228' => array('Lottery\Fucai3DWinning', 'group6PickForMultiBet'), //福彩3D组选6复式
    );

    public static function win($cat, $bonus, $bet){
        if(isset(self::$lotteryCats[$cat])){
            return call_user_func(self::$lotteryCats[$cat], $bonus, $bet);
        }else{
            return false;
        }

    }
}