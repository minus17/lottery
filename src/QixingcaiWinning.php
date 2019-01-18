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

class QixingcaiWinning extends WinningAbstract{
    static $winnings= array(
        7 => 1,
        6 => 2,
        5 => 3,
        4 => 4,
        3 => 5,
        2 => 6
    );

    /*
     * 命中解析
     * */
    public static function winning($bonus, $bet, $betMethod){
        switch ($betMethod){
            case 'single':
                return static::winningSingle($bonus, $bet); //单式
            default:
                return static::winningMultiple($bonus, $bet); //复式
        }
    }

    /*
     * 单式中奖计算
     * */
    public function winningSingle($bonus, $bet){
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
        if(isset(self::$winnings[$maxHit])){
            return self::$winnings[$maxHit];
        }else{
            return false;
        }
    }

    /*
     * 复式中奖计算
     * */
    public function winningMultiple($bonus, $bet){
        $betSet = LotteryMath::cartesian($bet);
        $res = array();
        foreach($betSet as $betItem){
            $curHits = self::winningSingle($bonus, $betItem);
            if($curHits){
                if(!isset($res[$curHits])){
                    $res[$curHits] = 1;
                }else{
                    $res[$curHits] ++;
                }
            }
        }
        return $res;
    }
}