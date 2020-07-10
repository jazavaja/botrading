<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Exchange extends Controller
{
    public function getPriceBinance($symble)
    {
        $sssss = str_replace("/", "", $symble);
        $url = "https://api.binance.com/api/v3/ticker/price?symbol=$sssss";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($output);
        return $result->price;
    }

}
