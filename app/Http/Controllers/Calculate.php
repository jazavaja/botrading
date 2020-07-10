<?php
/**
 * Created by PhpStorm.
 * User: javadSarlak
 * Date: 5/23/2020
 * Time: 4:36 PM
 */

namespace App\Http\Controllers;


class Calculate extends Controller
{
    public static function incPrice($number, $percent)
    {
        return $number + (1 / 100) * $percent * $number;
    }

    public static function calculateGrade($grade, $maxGrade)
    {
        $result = "";
        $a2 = ["A", "B", "C", "D", "E"];

        for ($i = 0; $i <= $maxGrade; $i++) {
            if ($grade == $i)
            {
                if ($grade == 0)
                {
                    $result = $a2[count($a2) - 1];
                } else if ($grade == $maxGrade)
                {
                    $result = $a2[count($a2) - $i];
                }else {
                    $result = $a2[count($a2) - $i - 1];
                }
                break;
            }
        }
        return $result;

    }

    public static function getDiffrentPercent($oldValue, $newValue)
    {
        $percent = (($newValue - $oldValue) / (abs($oldValue)) * 100);
        return round($percent, 2);
    }

    public static function risk_reward($targetProfit, $targetStopLoss, $entryPrice)
    {
        $rr = array();
        $percentProfit = self::getDiffrentPercent($entryPrice, $targetProfit);
        $percentStopLoss = self::getDiffrentPercent($entryPrice, $targetStopLoss);
        $riskReward = abs(round($percentProfit / $percentStopLoss, 2));
        $condition = 0;
        $grade = 0;
        if ($riskReward >= 1 && $riskReward < 1.5) {
            $grade = 1;
            $condition = 1;
        } elseif ($riskReward >= 1.5 && $riskReward < 2) {
            $grade = 2;
            $condition = 1;
        } elseif ($riskReward >= 2 && $riskReward < 2.5) {
            $grade = 3;
            $condition = 1;
        } elseif ($riskReward >= 2.5 && $riskReward < 3) {
            $grade = 4;
            $condition = 1;
        } elseif ($riskReward >= 3) {
            $grade = 5;
            $condition = 1;
        }
        array_push($rr, $condition);
        array_push($rr, $grade);
        array_push($rr, $riskReward);
        return $rr;

    }

    public static function decPrice($number, $percent)
    {
        return $number - (1 / 100) * $percent * $number;
    }

    public static function findStopLossInTwoResistance($resistance, $tolerance = 3)
    {
        $result = "";
        if (count($resistance) >= 2) {
            $rr = abs(self::getDiffrentPercent($resistance[0], $resistance[1]) / $tolerance);
            $result = Calculate::incPrice($resistance[0], $rr);
        } elseif (count($resistance) == 1) {
            $rr = abs(self::getDiffrentPercent($resistance[0], $resistance[1]) / $tolerance);
            $result = Calculate::incPrice($resistance[1], $rr);
        } elseif (count($resistance) == 0) {
            $result = -100;
        }
        return $result;
    }

    public static function findStopLossInTwoSupport($support, $tolerance = 3,$longOrShort="0")
    {

        $result = "";
        if (count($support) >= 2) {
            $rr = abs(self::getDiffrentPercent($support[0], $support[1]) / $tolerance);
            $result = Calculate::decPrice($support[0], $rr);
        } elseif (count($support) == 1) {
            $result=$support[0];
        } elseif (count($support) == 0) {
            $result = -100;
        }
        return $result;
    }

    public function nearPrice($price, $value, $telorance = 0.5)
    {
        $near = (($price - $value) / ($price)) * 100;
        if ($near <= $telorance && $near >= 0) {
            return true;
        } else {
            return false;
        }
    }
}