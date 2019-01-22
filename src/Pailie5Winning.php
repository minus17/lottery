<?php
/*
 * 排列5命中计算
 *
 * (c) wangtao <wangtao@p2peye.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Lottery;

class Pailie5Winning{

    /*
     * 单式中奖计算
     * eg. [1,2,3,4,5] [2,3,4,5,6]按位比较，顺序和数字全部一样为中奖
     * */
    public static function onePickForSingleBet($bonus, $bet){
        $hit = 1;
        //按位比对,如果不连续，$maxHit
        for($i = 0; $i < 5;$i ++){
            if($bonus[$i] != $bet[$i]){
                $hit = 0;
            }
        }
        return array('total' => 1, 'hit' => $hit);
    }

    /*
     * 复式中奖计算
     * */

    public static function onePickForMultiBet($bonus, $bet){
        $betSet = LotteryMath::cartesian($bet);
        $hit = array();
        foreach($betSet as $betItem){
            $curHit = self::onePickForSingleBet($bonus, $betItem);
            if($curHit['hit']){
                $curLevel = key($curHit['hit']);
                if(isset($hit[$curLevel])){
                    $hit[$curLevel] += current($curHit['hit']);
                }else{
                    $hit[$curLevel] = current($curHit['hit']);
                }
            }
        }
        return array('total' => count($betSet), 'hit' => $hit);
    }
}