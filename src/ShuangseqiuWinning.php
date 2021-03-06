<?php
/*
 * 双色球命中计算
 *
 * (c) wangtao <wangtao@p2peye.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Lottery;

class ShuangseqiuWinning{
    use LotteryCombine;
    static $winnings= array(
        1 => array(array(6,1)),
        2 =>array(array(6,0)),
        3 =>array(array(5,1)),
        4 =>array(array(5,0),array(4,1)),
        5 =>array(array(4,0),array(3,1)),
        6 =>array(array(2,1),array(1,1),array(0,1)),
    );

    /*
     * 单式中奖计算
     * */
    public static function onePickForSingleBet($bonus, $bet){
        $reqHits = $backHits = 0;
        foreach ($bet['0'] as $betItem){
            if(in_array($betItem, $bonus[0])){
                $reqHits ++;
            }
        }
        foreach ($bet['1'] as $betItem){
            if(in_array($betItem, $bonus[1])){
                $backHits ++;
            }
        }
        return array('total' => 1, 'hit' => self::parseHit(6, $reqHits, 0, 0, 1, $backHits));
    }

    /*
     * 复式中奖计算
     * */
    public static function onePickForMultiBet($bonus, $bet){
        $opt = count($bet['0']);
        $back = count($bet['1']);
        $optHits = $backHits = 0;
        foreach ($bet['0'] as $betItem){
            if(in_array($betItem, $bonus[0])){
                $optHits ++;
            }
        }
        foreach ($bet['1'] as $betItem){
            if(in_array($betItem, $bonus[1])){
                $backHits ++;
            }
        }
        $total = LotteryMath::C(count($bet['0']), 6) * LotteryMath::C(count($bet['1']), 1);
        return array('total' => $total, 'hit' => self::parseHit(0, 0, $opt, $optHits, $back, $backHits));
    }

    /*
     * 胆拖中奖计算
     * */
    public static function onePickForOptBet($bonus, $bet){
        $req = count($bet['0']);
        $opt = count($bet['1']);
        $back = count($bet['2']);
        $reqHits = $optHits = $backHits = 0;
        foreach ($bet['0'] as $betItem){
            if(in_array($betItem, $bonus[0])){
                $reqHits ++;
            }
        }
        foreach ($bet['1'] as $betItem){
            if(in_array($betItem, $bonus[0])){
                $optHits ++;
            }
        }
        foreach ($bet['2'] as $betItem){
            if(in_array($betItem, $bonus[1])){
                $backHits ++;
            }
        }
        $total = LotteryMath::C(count($bet[1]), 6 - count($bet[0])) * LotteryMath::C(count($bet['2']), 1);
        return array('total' => $total, 'hit' => self::parseHit($req, $reqHits, $opt, $optHits, $back, $backHits));
    }

    /*
     * 公有计算逻辑
     * */
    private static function parseHit($req, $reqHits, $opt, $optHits, $back, $backHits){
        $res = array();
        $redWin = self::parseCombineHit($req, $reqHits, $opt, $optHits);
        $blueWin = self::parseCombineHit(0, 0, $back, $backHits, 1);

        foreach(self::$winnings as $level => $winning){
            $curLevelCount = 0;
            foreach($winning as $item){
                $curLevelCount += $redWin[$item[0]] * $blueWin[$item[1]];
            }
            if($curLevelCount > 0){
                $res[$level] = $curLevelCount;
            }
        }
        return $res;
    }
}