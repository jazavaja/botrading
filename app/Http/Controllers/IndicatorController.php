<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mockery\Exception;

class IndicatorController extends Controller
{
    public $sleep = 130;
    public $url = "https://ta.taapi.io/";
    public $api = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJlbWFpbCI6ImFidGluYWZyYXpAZ21haWwuY29tIiwiaWF0IjoxNTg5MTk0OTU1LCJleHAiOjc4OTYzOTQ5NTV9.GmCFBPLgc-c4DDLRlSqZYXFjykl2g2mRgjaZMYPH4sU";
    public $binance = "binance";
    
    public function getRSI_Method($symbol, $timeFrame, $backtrack = 0, $period = 14)
    {
        $this->m_sleep($this->sleep);
        $query = http_build_query(array(
            'secret' => $this->api,
            'exchange' => $this->binance,
            'symbol' => $symbol,
            'interval' => $timeFrame,
            'backtrack' => $backtrack,
            'optInTimePeriod' => $period,
        ));
        $endpoint = "rsi";
        $url = "https://ta.taapi.io/{$endpoint}?{$query}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        curl_multi_init();

        $res = json_decode($output);
        if (!empty($res->value)) {
            return $res->value;
        } else {
            return $output;
        }
    }

    function m_sleep($milliseconds)
    {
        return usleep($milliseconds * 1000); // Microseconds->milliseconds
    }

    public function getEMA_Method($symbol, $timeFrame, $period, $backtrack = 0)
    {
        $result = $this->requestTaapi("ema", $this->api, $symbol, $timeFrame, $period, $backtrack);
        $res = json_decode($result);
        $this->m_sleep($this->sleep);
        if (!empty($res->value)) {
            return $res->value;
        } else {
            return $result;
        }
    }

    public function getMa_Mathod($symbol, $timeFrame, $period, $backtrack)
    {
        $result = $this->requestTaapi("ma", $this->api, $symbol, $timeFrame, $period, $backtrack);
        $res = json_decode($result);
        $this->m_sleep($this->sleep);
        if (!empty($res->value)) {
            return $res->value;
        } else {
            return $result;
        }
    }

    public function getMacd_Mathod($symbol, $timeFrame, $optInFastPeriod = 12, $optInSlowPeriod = 26, $optInSignalPeriod = 9, $backtrack = 0)
    {
        $this->m_sleep($this->sleep);
        $query = http_build_query(array(
            'secret' => $this->api,
            'exchange' => $this->binance,
            'symbol' => $symbol,
            'interval' => $timeFrame,
            'backtrack' => $backtrack,
            'optInFastPeriod' => $optInFastPeriod,
            'optInSlowPeriod' => $optInSlowPeriod,
            'optInSignalPeriod' => $optInSignalPeriod,
        ));
        $endpoint = "macd";
        $url = "https://ta.taapi.io/{$endpoint}?{$query}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        curl_multi_init();

        $res = json_decode($output);
        if (!empty($res->valueMACD)) {
            $array = array();
//            array_push($array,abs($res->valueMACD));
//            array_push($array,abs($res->valueMACDSignal));
//            array_push($array,abs($res->valueMACDHist));

            array_push($array, ($res->valueMACD));
            array_push($array, ($res->valueMACDSignal));
            array_push($array, ($res->valueMACDHist));
            return $array;
        } else {
            return $output;
        }
//        return $output;
    }

    public function getFibonacciRetracementMethod($symbol, $timeFrame, $period, $retracement = "0.618")
    {
        $this->m_sleep($this->sleep);
        $result = $this->requestTaapi("fibonacciretracement", $this->api, $symbol, $timeFrame, $period, $retracement);
        $res = json_decode($result);
        if (!empty($res->value)) {
            return $res->value;
        } else {
            return $result;
        }
    }

    private function requestTaapi($endpoint, $secret, $symbol, $timeFrame, $optInTimePeriod, $retracement = 0.618, $backtrack = "0", $exchange = "binance")
    {
        $query = http_build_query(array(
            'secret' => $secret,
            'exchange' => $exchange,
            'symbol' => $symbol,
            'interval' => $timeFrame,
            'backtrack' => $backtrack,
            'optInTimePeriod' => $optInTimePeriod,
            'period' => $optInTimePeriod,
            'retracement' => $retracement
        ));
        $url = "https://ta.taapi.io/{$endpoint}?{$query}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        curl_multi_init();
        return $output;
    }
}
