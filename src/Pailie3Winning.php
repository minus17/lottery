<?php
/*
 * 排列3命中计算
 *
 * (c) wangtao <wangtao@p2peye.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Lottery;

class Pailie3Winning{

    /*
     * 直选单式中奖计算
     * eg. [1,2,3] [2,3,4]按位比较，顺序和数字全部一样为中奖
     * */
    public static function onePickForSingleBet($bonus, $bet){
        $hit = 1;
        //按位比对,如果不连续，$maxHit
        for($i = 0; $i < 3;$i ++){
            if($bonus[$i] != $bet[$i]){
                $hit = 0;
            }
        }
        return array('total' => 1, 'hit' => $hit);
    }

    /*
     * 直选复式中奖计算
     * 排列三直选复式：当百位号码、十位号码、个位号码中至少有一个位选择号码的个数多于一个，组成多注投注号码的投注，即为排列三直选复式投注。
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

    /*
     * 组选3单式中奖计算
     * 只要数都出现在就中奖
     * */
    public function group3PickForSingleBet($bonus, $bet){
        $hit = 1;
        $bonusUnique = array_unique($bonus);
        //如果不是有2个数一样，直接判定未中奖
        if(count($bonusUnique) != 2){
            $hit = 0;
        }else{
            //单式只要有一位数不一致（不全等）就每中
            foreach ($bet as $betItem){
                if(!in_array($betItem, $bonusUnique)){
                    $hit = 0;
                    break;
                }
            }
        }
        return array('total' => 1, 'hit' => $hit);
    }

    /*
     * 组选3复式中奖计算
     * 只要有2个数出现就中奖
     * */
    public function group3PickForMultiBet($bonus, $bet){
        $hit = 0;
        $bonusUnique = array_unique($bonus);
        //如果不是有2个数一样，直接判定未中奖
        if(count($bonusUnique) != 2){
            $hit = 0;
        }else{
            $hits = 0;
            //单式只要有一位数不一致（不全等）就每中
            foreach ($bet as $betItem){
                if(in_array($betItem, $bonusUnique)){
                    $hits++;
                }
                if($hits == 2){
                    $hit = 1;
                    break;
                }
            }
        }
        $total = LotteryMath::C(count($bet), 2);
        return array('total' => $total, 'hit' => $hit);
    }

    /*
     * 组选6单式中奖计算
     * 只要数都出现在就中奖
     * */
    public function group6PickForSingleBet($bonus, $bet){
        $hit = 1;
        $bonusUnique = array_unique($bonus);
        //如果不是有3个数都不同，直接判定未中奖
        if(count($bonusUnique) != 3){
            $hit = 0;
        }else{
            //单式只要有一位数不一致（不全等）就每中
            foreach ($bet as $betItem){
                if(!in_array($betItem, $bonusUnique)){
                    $hit = 0;
                    break;
                }
            }
        }
        return array('total' => 1, 'hit' => $hit);
    }

    /*
     * 组选6复式中奖计算
     * 只要有3个数出现就中奖
     * */
    public function group6PickForMultiBet($bonus, $bet){
        $hit = 0;
        $bonusUnique = array_unique($bonus);
        //如果不是有2个数一样，直接判定未中奖
        if(count($bonusUnique) != 3){
            return false;
        }else{
            $hits = 0;
            //单式只要有一位数不一致（不全等）就每中
            foreach ($bet as $betItem){
                if(in_array($betItem, $bonusUnique)){
                    $hits++;
                }
                if($hits == 3){
                    $hit = 1;
                    break;
                }
            }
        }
        $total = LotteryMath::C(count($bet), 3);
        return array('total' => $total, 'hit' => $hit);
    }
}