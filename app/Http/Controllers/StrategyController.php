<?php

namespace App\Http\Controllers;

use App\Jobs\SendAnalysis;
use App\Jobs\Test;
use App\Notify;
use App\Pair;
use Artisan;
use PhpParser\JsonDecoder;


class StrategyController extends Controller
{
    public $api = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJlbWFpbCI6ImFidGluYWZyYXpAZ21haWwuY29tIiwiaWF0IjoxNTg5MTk0OTU1LCJleHAiOjc4OTYzOTQ5NTV9.GmCFBPLgc-c4DDLRlSqZYXFjykl2g2mRgjaZMYPH4sU";

    public function doingAnalytics()
    {
        Telegram::removeAlert();
        $pair = Pair::get();
        foreach ($pair as $item) {
            SendAnalysis::dispatch($item);
        }
    }

    public function collionEMAprice($ema, $ma, $low, $high)
    {
        if (($ma >= $low && $ma < $high) || ($ema >= $low && $ema < $high)) {
            return true;
        } else {
            return false;
        }
    }

    public function volumePositive($close, $open)
    {
        if ($close > $open) {
            return true;
        } else {
            return false;
        }
    }

    public function strategyFarshad($symbol, $timeFrame)
    {
        $indicator = new IndicatorController();
        $exchange = new Exchange();
        $ma150 = $indicator->getMa_Mathod($symbol, $timeFrame, 150, 0);
        $ema200 = $indicator->getEMA_Method($symbol, $timeFrame, 200, 0);
        $candel = $indicator->getCandles_Method($symbol, $timeFrame, 1);
        $jj = new JsonDecoder();
        $rr = json_decode($candel);

        $vv = $this->volumePositive($rr[0]->close, $rr[0]->open);
        $cc = $this->collionEMAprice($ema200, $ma150, $rr[0]->low, $rr[0]->high);

        Telegram::sendTelegram(
            "Pair: " . $symbol . "\n" .
            "EMA200 :" . Telegram::format($ema200) . "\n" .
            "MA150 :" . Telegram::format($ma150) . "\n" .
            "candel low :" . Telegram::format($rr[0]->low) . "\n" .
            "candel high :" . Telegram::format($rr[0]->high) . "\n" .
            "volume positive:" . $vv . "\n"
        );
        if ($vv && $cc) {
            $price = $exchange->getPriceBinance($symbol);
            Telegram::bigPump($symbol, $timeFrame, $price);
        }
    }

    public function strategyTeamtextMarginCoin($symbol, $timeFrame)
    {
        Telegram::removeAlert();
        $maxConditionLong = 12;
        $maxConditionShort = 3;
        $grade = 0;
        $p = new Exchange();
        $price = $p->getPriceBinance($symbol);
        $fiboCandle = 200;
        $conditionLong = 0;
        $conditionShort = 0;
        $indicator = new IndicatorController();

        $rsi = $indicator->getRSI_Method($symbol, $timeFrame);
        $macdNow = $indicator->getMacd_Mathod($symbol, $timeFrame, 12, 26, 9, 0);
        $macdLater = $indicator->getMacd_Mathod($symbol, $timeFrame, 12, 26, 9, 3);
        $fibo0 = ($indicator->getFibonacciRetracementMethod($symbol, $timeFrame, $fiboCandle, "0"));
        $fibo236 = ($indicator->getFibonacciRetracementMethod($symbol, $timeFrame, $fiboCandle, "0.236"));
        $fibo382 = ($indicator->getFibonacciRetracementMethod($symbol, $timeFrame, $fiboCandle, "0.382"));
        $fibo618 = ($indicator->getFibonacciRetracementMethod($symbol, $timeFrame, $fiboCandle, "0.618"));
        $fibo786 = ($indicator->getFibonacciRetracementMethod($symbol, $timeFrame, $fiboCandle, "0.786"));
        $fibo1 = ($indicator->getFibonacciRetracementMethod($symbol, $timeFrame, $fiboCandle, "1"));

        $all = array();
        array_push($all, $fibo0);
        array_push($all, $fibo236);
        array_push($all, $fibo382);
        array_push($all, $fibo618);
        array_push($all, $fibo786);
        array_push($all, $fibo1);
        $resistance = ($this->resistanceLines($all, $price));
        $support = ($this->supportLines($all, $price));

//        var_dump($resistance);
//        var_dump($support);
        $conditionCross = $this->conditionCross($macdNow[0], $macdNow[1], $macdLater[0], $macdLater[1]);
        $stopLossForLong = Calculate::findStopLossInTwoSupport($support);
        $riskRewardLong = Calculate::risk_reward($resistance[0], $stopLossForLong, $price);
//
        $conditionLong += $this->conditionRSI($rsi);
        $conditionLong += $conditionCross;
        $conditionLong += $riskRewardLong[0];

        $stopLossForShort = Calculate::findStopLossInTwoResistance($resistance);
        $riskRewardShort = Calculate::risk_reward($support[0], $stopLossForShort, $price);

        $conditionShort += $this->conditionRSI($rsi);
        $conditionShort += $conditionCross;
        $conditionShort += $riskRewardShort[0];

        $grade += $this->gradeForRSI($rsi, $conditionCross);
        $grade += $this->gradeForMacd($macdNow[0], $macdNow[1], $conditionCross);


        if ($conditionLong == $maxConditionLong && $stopLossForLong != -100) {
            Telegram::textForStaregyTVT_Long($symbol, $timeFrame, $price, $resistance, $stopLossForLong, $grade, $riskRewardLong[2]);
        }
        if ($conditionShort == $maxConditionShort && $stopLossForShort != 100) {
            Telegram::textForStaregyTVT_Short($symbol, $timeFrame, $price, $support, $stopLossForShort, $grade, $riskRewardShort[2]);
        }

        Telegram::sendTelegram("Pair: " . $symbol . "\n"
            . "timeframe: " . $timeFrame . "\n"
            . "riskreward: " . $riskRewardLong[2] . "\n"
            . "conditionLong: " . $conditionLong . "\n"
            . "conditionShort: " . $conditionShort . "\n"
            . "cross: " . $conditionCross . "\n"
            . "stopLoss: " . $stopLossForLong . "\n"
            . "GRADE: " . $grade . "\n"
            . "Fibos: " . $fibo0 . " " . $fibo236 . " " . $fibo382 . " " . $fibo618 . " " . $fibo786 . " " . $fibo1 . "\n"
            . "RSI: " . $rsi . "\n"
            . "macdNow" . $macdNow[0] . "#" . $macdNow[1] . "#" . $macdNow[2] . "\n"
            . "macdLater" . $macdLater[0] . "#" . $macdLater[1] . "#" . $macdLater[2] . "\n"
        );
    }

    public function resistanceLines($all, $price, $telorance = 0.6)
    {
        $res = array();
        foreach ($all as $item) {
            if ($price < $item) {
                array_push($res, $item);
            }
        }
        $yy = array();
        foreach ($res as $tt) {
            $dif = Calculate::getDiffrentPercent($price, $tt);
            if ($dif <= $telorance) {
            } else {
                $rr = abs(Calculate::getDiffrentPercent($price, $tt) / 3);
                $tt = Calculate::decPrice($tt, $rr);
                array_push($yy, $tt);
            }
        }
        sort($yy);
        return $yy;
    }

    public function supportLines($all, $price, $telorance = 0.6)
    {

        $res = array();
        foreach ($all as $item) {
//            $dif = Calculate::getDiffrentPercent($item, $price);
            if ($price > $item) {
                array_push($res, $item);
            }
        }
        $yy = array();
//        $yy=$res;
        foreach ($res as $tt) {
            $dif = Calculate::getDiffrentPercent($tt, $price);
            if ($dif <= $telorance) {
            } else {
                array_push($yy, $tt);
            }
        }
        rsort($yy);
        return $yy;
    }

    public function gradeForRSI($value, $pumpOrDump)
    {
        if ($value < 52 && $value > 48) {
            return 0;
        } else if ($value > 52 && $pumpOrDump == 10) {
            return 2;
        } elseif ($value < 48 && $pumpOrDump == 1) {
            return 1;
        } else if ($value > 52 && $pumpOrDump == 10) {
            return 1;
        } elseif ($value < 48 && $pumpOrDump == 1) {
            return 2;
        }
    }

    public function gradeForMacd($macd, $signal, $pumpOrDump)
    {
        if ($signal <= 0 && $macd <= 0 && $pumpOrDump == 10) {
            return 2;
        } elseif ($signal > 0 && $macd > 0 && $pumpOrDump == 10) {
            return 1;
        } elseif ($signal > 0 && $macd > 0 && $pumpOrDump == 1) {
            return 2;
        } elseif ($signal < 0 && $macd < 0 && $pumpOrDump == 1) {
            return 1;
        } else {
            return 0;
        }
    }

    public function conditionCross($valueA, $valueB, $valueA_Later, $valueB_Later)
    {
        $t = 0;
        if ($valueA > $valueB && $valueA_Later < $valueB_Later) {
            $t = 10;
            return $t;
        } else if ($valueA < $valueB && $valueA_Later > $valueB_Later) {
            $t = 1;
            return $t;
        } else {
            return $t;
        }
    }

    public function conditionRSI($value)
    {
        if ($value > 30 && $value < 70) {
            return 1;
        } else
            return 0;
    }
}