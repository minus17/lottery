<?php
/*
 * 大乐透命中计算
 *
 * (c) wangtao <wangtao@p2peye.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Lottery;

class DaletouWinning{
    use LotteryCombine;
    static $winnings= array(
        1 => array(array(5,2)),
        2 =>array(array(5,1)),
        3 =>array(array(5,0),array(4,2)),
        4 =>array(array(4,1),array(3,2)),
        5 =>array(array(4,0),array(3,1),array(2,2)),
        6 =>array(array(3,0),array(1,2),array(2,1),array(0,2)),
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
        return array('total' => 1, 'hit' => self::parseHit(5, $reqHits, 0, 0, 2, $backHits, 0, 0));
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
        $total = LotteryMath::C(count($bet['0']), 5) * LotteryMath::C(count($bet['1']), 2);
        return array('total' => $total, 'hit' => self::parseHit(0, 0, $opt, $optHits, 0, 0, $back, $backHits));
    }

    /*
     * 胆拖中奖计算
     * */
    public static function onePickForOptBet($bonus, $bet){
        $fReq = count($bet['0']);
        $fOpt = count($bet['1']);
        $bReq = count($bet['2']);
        $bOpt = count($bet['3']);
        $fReqHits = $fOptHits = $bReqHits = $bOptHits = 0;
        foreach ($bet['0'] as $betItem){
            if(in_array($betItem, $bonus[0])){
                $fReqHits ++;
            }
        }
        foreach ($bet['1'] as $betItem){
            if(in_array($betItem, $bonus[0])){
                $fOptHits ++;
            }
        }
        foreach ($bet['2'] as $betItem){
            if(in_array($betItem, $bonus[1])){
                $bReqHits ++;
            }
        }
        foreach ($bet['3'] as $betItem){
            if(in_array($betItem, $bonus[1])){
                $bOptHits ++;
            }
        }
        $total = LotteryMath::C(count($bet[1]), 5 - count($bet[0])) * LotteryMath::C(count($bet['3']), 1);
        return array('total' => $total, 'hit' => self::parseHit($fReq, $fReqHits, $fOpt, $fOptHits, $bReq, $bReqHits, $bOpt, $bOptHits));
    }

    /*
     * 公有计算逻辑
     * */
    private static function parseHit($fReq, $fReqHits, $fOpt, $fOptHits, $bReq, $bReqHits, $bOpt, $bOptHits){
        $res = array();
        $forwardWin = self::parseCombineHit($fReq, $fReqHits, $fOpt, $fOptHits, 5);
        $backWin = self::parseCombineHit($bReq, $bReqHits, $bOpt, $bOptHits, 2);

        foreach(self::$winnings as $level => $winning){
            $curLevelCount = 0;
            foreach($winning as $item){
                $curLevelCount += $forwardWin[$item[0]] * $backWin[$item[1]];
            }
            if($curLevelCount > 0){
                $res[$level] = $curLevelCount;
            }
        }
        return $res;
    }
}