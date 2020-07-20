@extends('files.layout')
@section('content')
    <div class="col-md-12">
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
                                {{$item->setting}}
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
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection