<?php
/*
 * 七星彩命中计算
 *
 * (c) wangtao <wangtao@p2peye.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Lottery;

class QixingcaiWinning{
    static $winnings= array(
        7 => 1,
        6 => 2,
        5 => 3,
        4 => 4,
        3 => 5,
        2 => 6
    );

    /*
     * 单式中奖计算
     * */
    public static function onePickForSingleBet($bonus, $bet){
        $maxHit = 0;
        $curHit = 0;
        //按位比对,如果不连续，$maxHit
        for($i = 0; $i < 7;$i ++){
            if($bonus[$i] == $bet[$i]){
                $curHit ++;
                $maxHit = max($curHit, $maxHit);
            }else{
                //按位不相同,重置连续命中计数
                $curHit = 0;
            }
        }
        $hit = array();
        if(isset(self::$winnings[$maxHit])){
            $hit = array(self::$winnings[$maxHit] => 1);
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