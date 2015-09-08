@extends('app')
@section('title')
    {{$item->name}}
@stop
@section('content')
    <div class="row">
        <div class="col-lg-4">
            <img src="{{URL::asset('images/'.$item->picture)}}" class="item_image"/>
        </div>
        <div class="col-lg-8">
            <h1>
                <kbd>{{$item->name}}</kbd>
            </h1>
            <hr>
            <p>
                {{ $item->price_31_a}} : 31 A @lang('variables.price')
            </p>

            <div class="center">
                <table class="table table-hover right">
                    <caption class="color_pink title3">@lang('variables.prices')</caption>
                    <thead>
                    <tr>
                        <th class="right">@lang('variables.price')</th>
                        <th class="right">@lang('variables.type')</th>

                    </tr>
                    </thead>
                    <tbody>

                    @if(Auth::user()->type=='admin')
                        <tr>
                            <td> {{ $item->price_31_a}} </td>
                            <td> A 31 @lang('variables.price')</td>
                            {{--<td><span class="glyphicon glyphicon-tag"></span></td>--}}
                        </tr>
                        <tr>
                            <td> {{ $item->price_32_b}} </td>
                            <td> B 32 @lang('variables.price')</td>
                            {{--<td><span class="glyphicon glyphicon-tag"></span></td>--}}
                        </tr>
                        <tr>
                            <td> {{ $item->price_1034}} </td>
                            <td> 1034 @lang('variables.price')</td>
                            {{--<td><span class="glyphicon glyphicon-tag"></span></td>--}}
                        </tr>
                    @endif
                    <tr>
                        <td> {{ $item->price_1050}} </td>
                        <td> 1050 @lang('variables.price')</td>
                        {{--<td><span class="glyphicon glyphicon-tag"></span></td>--}}
                    </tr>
                    <tr>
                        <td> {{ $item->price_1250}} </td>
                        <td> 1250 @lang('variables.price')</td>
                        {{--<td><span class="glyphicon glyphicon-tag"></span></td>--}}
                    </tr>
                    </tbody>
                </table>


            </div>
        </div>
    </div>
@stop