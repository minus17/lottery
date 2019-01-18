<?php
/*
 * 计算彩票助手工具
 *
 * (c) wangtao <wangtao@p2peye.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lottery;

trait LotteryCombine
{
    /*
     * 组合类型命中计算
     * @param req 胆个数
     * @param reqHits 命中胆个数
     * @param opt 拖个数
     * @param optHits 命中拖个数
     * @param total 总位数
     * @return mixed
     * */
    public static function parseCombineHit($req, $reqHits, $opt, $optHits, $total = 6){
        $res = array();
        $totalHits = $reqHits + $optHits;
        $posLeft = $total - $req;
        $optMiss = $opt - $optHits;
        //循环假设总命中数
        for($i = 0;$i <= $total; $i++){
            if($i < $reqHits || $i > $totalHits){
                $res[$i] = 0; //这里都是中奖命中数没办法满足的，没办法中奖
            }else{
                //需要消耗几个命中的拖
                $optHitsNeed = $i - $reqHits;
                if($optMiss < ($posLeft - $optHitsNeed)){
                    $res[$i] = 0; //未命中的拖不够填空了，这种中奖方式不成立
                }else{
                    $res[$i] = LotteryMath::C($optHits, $optHitsNeed) * LotteryMath::C($optMiss, $posLeft - $optHitsNeed);
                }
            }
        }
        return $res;
    }
}