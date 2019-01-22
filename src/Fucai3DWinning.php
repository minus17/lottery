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

class Fucai3DWinning{
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
     * 单选单复式中奖计算
     * 单选单复式是3D游戏复式投注的一种方式，是指从0-9共10个数字中，选择3—8个进行包括所选号码且三位数各不相同的单选投注。
     * */
    public static function onePickForSingleMultiBet($bonus, $bet){
        $hit = 0;
        $bonusUnique = array_unique($bonus);
        //如果不是全不一样，直接判定未中奖
        if(count($bonusUnique) != 3){
            return false;
        }
        $hits = 0;
        foreach ($bet as $betItem){
            if(in_array($betItem, $bonus)){
                $hits ++;
            }
            if($hits == 3){
                $hit = 1;
                break;
            }
        }

        $total = LotteryMath::A(count($bet), 3);
        return array('total' => $total, 'hit' => $hit);
    }

    /*
     * 单选双复式中奖计算
     * 单选双复式是指单选全复式的号码中有且仅有两位数相同的组合进行单式投注
     * */
    public static function onePickForDoubleMultiBet($bonus, $bet){
        $bonusUnique = array_unique($bonus);
        //如果全不一样或全一样直接判定未中奖
        if(count($bonusUnique) != 2){
            return false;
        }
        $hit = 0;
        $hits = 0;
        foreach ($bet as $betItem){
            if(in_array($betItem, $bonusUnique)){
                $hits ++;
            }
            if($hits == 2){
                $hit = 1;
                break;
            }
        }

        $total = LotteryMath::C(count($bet), 2) * 6;
        return array('total' => $total, 'hit' => $hit);
    }

    /*
     * 单选全复式中奖计算
     * 单选双复式是指单选全复式的号码中有且仅有两位数相同的组合进行单式投注
     * 相当于3位的七星彩
     * */
    public static function onePickForFullMultiBet($bonus, $bet){
        $bonusUnique = array_unique($bonus);
        $hit = 0;
        $hits = 0;
        foreach ($bet as $betItem){
            if(in_array($betItem, $bonusUnique)){
                $hits ++;
            }
            if($hits == count($bonusUnique)){
                $hit = 1;
                break;
            }
        }
        //3个都不一样的全排列
        $total = pow(count($bet), 3);
        return array('total' => $total, 'hit' => $hit);
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