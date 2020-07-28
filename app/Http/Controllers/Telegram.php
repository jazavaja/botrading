<?php

namespace App\Http\Controllers;

use App\Notify;
use Illuminate\Http\Request;

class Telegram extends Controller
{

    public static function sendTelegram($text, $bot = "@test0version")
    {
        $textEncode = urlencode($text);
        $url = "https://api.telegram.org/bot973081134:AAGP0uEl-PXPn3tBLgVPSxA8GUNnYc8u564/sendMessage?chat_id=$bot&text=$textEncode";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
    }

    public static function kickChatMember($user, $bot = "@test0version")
    {
        $textEncode = urlencode($user);
        $url = "https://api.telegram.org/bot973081134:AAGP0uEl-PXPn3tBLgVPSxA8GUNnYc8u564/kickChatMember?chat_id=$bot&user_id=$textEncode";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    public static function format($number){

        return number_format(floatval($number),8,".","");

    }
    public static function bigPump($pair, $time, $price)
    {
        $add = self::addAlerts($pair, $time);
        if ($add) {
            self::sendTelegram(
                "LongPosition: " . $pair . "\n" .
                $time . "\n" .
                "priceNow : " . Telegram::format($price).
                "Target1 3% : " . Telegram::format((Calculate::incPrice($price,3))).
                "Target2 5% : " . Telegram::format((Calculate::incPrice($price,5))).
                "Target3 7%: " . Telegram::format((Calculate::incPrice($price,7))).
                "StopLoss 3%: " . Telegram::format((Calculate::decPrice($price,3)))
                , "-1001465828957");
            self::sendTelegram("Big Pump :" . $pair . "\n" . $time . "\n" . "priceNow : " . $price, "-1001266411642");
        }
    }


    public static function resistanceLines($all, $price)
    {
        $res = array();
        foreach ($all as $item) {
            if ($price < $item) {
                array_push($res, $item);
            }
        }
        sort($res);
        return $res;
    }

    public static function textForStaregyTVT_Long($pair, $timeFrame, $price, $resistance, $support, $grade, $riskReward, $condition = 0)
    {
        $res = "";
        $i = 1;
        $gradeFinal = Calculate::calculateGrade($grade, 4);


        foreach ($resistance as $item) {
            $res .= "✅TargetProfit $i : " . $item . "\n";
            $i++;
        }
        $res .= "--------------------------" . "\n";
//        foreach ($support as $items){
        $res .= "⛔TargetStopLoss : " . $support . "\n";
//        }

        $text =
            "Long Position" . "\n" .
            $pair . "  📈 📈  " . "\n" .
            "Risk/Reward : " . $riskReward . "\n" .
            "Grade : " . " $gradeFinal" . "\n" .
            "TimeFrame: 🕗 " . $timeFrame . "\n" .
            "Price Now 💲: " . $price . "\n" .
            $res . "\n";
        $add = self::addAlerts($pair, $timeFrame);
        if ($add) {
            self::sendTelegram($text, "-1001266411642");
            self::sendTelegram($text, "-1001465828957");
        }
    }

    public static function textForStaregyTVT_Short($pair, $timeFrame, $price, $supportTarget, $resisranceStopLoss, $grade, $riskReward)
    {
        $res = "";
        $i = 1;
        $gradeFinal = Calculate::calculateGrade($grade, 4);
        foreach ($supportTarget as $item) {

            $res .= "✅TargetProfit $i : " . $item . "\n";
            $i++;
        }
        $i = 1;
        $res .= "--------------------------" . "\n";

        $res .= "⛔TargetStopLoss : " . $resisranceStopLoss . "\n";

        $text =
            "Short Position" . "\n" .
            $pair . "  📉 📉 " . "\n" .
            "Risk/Reward : " . $riskReward . "\n" .
            "Grade : " . " $gradeFinal" . "\n" .
            "TimeFrame: 🕗 " . $timeFrame . "\n" .
            "Price Now 💲: " . $price . "\n" .
            $res . "\n";

//        self::sendTelegram($text);
        $add = self::addAlerts($pair, $timeFrame);
        if ($add) {
            self::sendTelegram($text, "-1001266411642");
            self::sendTelegram($text, "-1001465828957");
        }
    }

    public static function addAlerts($pair, $timeFrame)
    {
        if (Telegram::checkAlertHave($pair, $timeFrame)) {
            $notify = new Notify();
            $notify->pair = $pair;
            $notify->timeframe = $timeFrame;
            $notify->timeNotify = time();
            $notify->save();
            return true;
        } else {
            return false;
        }
    }

    public static function checkAlertHave($pair, $timeFrame)
    {
        $t = Notify::where('pair', '=', $pair)->where('timeframe', '=', $timeFrame)->count();
        if ($t == 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function removeAlert($min1h = 400, $min4h = 1300, $minDay = 9000)
    {
        $n = Notify::get();
        foreach ($n as $item) {
            $timeNotify = $item["timeNotify"];
            $id = $item["id"];
            $remind = Telegram::remind($timeNotify);
            if ($remind > $min1h) {
                Notify::where('id', '=', $id)->where('timeframe', '=', '1h')->delete();
            } elseif ($remind > $min4h) {
                Notify::where('id', '=', $id)->where('timeframe', '=', '4h')->delete();
            } elseif ($remind > $minDay) {
                Notify::where('id', '=', $id)->where('timeframe', '=', '1d')->delete();
            }
        }
    }

    public static function remind($timeNotify)
    {
        $tMines = round(((time() - $timeNotify) / 60));
        return $tMines;
    }

}
