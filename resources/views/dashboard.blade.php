@extends('files.layout')
@section('content')
    <div class="col-md-12">
        <form  action="/indicatorNewSave" method="POST">
            @csrf
        <div class="row">

            <div class="col-md-2">
                <label>
                    <select name="func" class="form-control">

                        @php
                        $allf=\App\Func::all();
                        @endphp
                        @foreach($allf as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="col-md-4">
                <div class="form-group bmd-form-group">
                    <label class="bmd-label-floating">Setting</label>
                    <input type="text" name="setting" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <label>
                    <select name="timeframe" class="form-control">
                        @php
                        $alls=\App\Timeframe::all();
                        @endphp
                        @foreach($alls as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </label>
            </div>
            <div class="col-md-2">
                <div class="form-group bmd-form-group">
                    <label class="bmd-label-floating">backtrack</label>
                    <input name="backtrack" type="text" class="form-control">
                </div>
            </div>
            <input type="submit" name="save" value="Save">
        </div>
        </form>
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title ">Indicators</h4>
                <p class="card-category">Show all indicators</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                        <tr>
                            <th>
                                ID
                            </th>
                            <th>
                                Name
                            </th>
                            <th>
                                Setting
                            </th>
                            <th>
                                TimeFrame
                            </th>
                            <th>
                                backtrack
                            </th>
                            <th>
                                Exchange
                            </th>
                            <th>
                                description
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                        $ind=new \App\IndicatorModel();
                        $rr=\App\IndicatorModel::all();
                        @endphp

                        @foreach ($rr as $item)
                        <tr>
                            <td>

                            </td>
                            <td>
                                {{$item->name()->first()->name}}
                            </td>
                            <td>
                                @foreach($item->setting as $u)
                                {{$u}}
                                @endforeach
                            </td>
                            <td>
                                  {{$item->timeFrame()->first()->name}}
                            </td>
                            <td class="text-primary">
                                {{$item->backtrack}}
                            </td>
                            <td class="text-primary">
                                {{$item->exchange}}
                            </td>
                            <td class="text-primary">
                                {{$item->description}}
                            </td>
                            <td class="text-primary">
                               <a href="/deleteIndicator/{{$item->id}}">delete</a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection