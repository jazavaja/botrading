<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\IndicatorModel;
use Illuminate\Http\Request;

class Indicator extends Controller
{
    function addNewIndicator(Request $request)
    {
        $ind = new IndicatorModel();
        $ind->name = $request->get('func');
        $sett = $request->get('setting');
        $reSetting = explode(",", $sett);
        $ind->setting = ($reSetting);
        $ind->timeFrame = $request->get('timeframe');
        if ($request->get('backtrack') == "")
            $ind->backtrack = 0;
        else
            $ind->backtrack = $request->get('backtrack');
        $ind->save();
        return redirect()->back();
    }
//number_format('',8,".","");

    function removeIndicator(Request $request, $id)
    {
        IndicatorModel::where('id', '=', $id)->delete();
        return redirect()->back();
    }
}
