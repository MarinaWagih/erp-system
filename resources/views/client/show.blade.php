@extends('app')
@section('title')
    {{$client->name}}
@stop
@section('content')
    <div class="row">
        <div class="col-lg-2">
            <a href="/client/{{$client->id}}/edit">
                <h2 class="link">
                    @lang('variables.edit')
                    <span class="glyphicon glyphicon-edit"></span>

                </h2>
            </a>
            @if(Auth::user()->type=='admin')
                <a href="/client/{{$client->id}}/delete">
                    <h2 class="link">
                        @lang('variables.delete')
                        <span class="glyphicon glyphicon-remove"></span>

                    </h2>
                </a>
            @endif
        </div>
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="color title2 panel_title">

                    <a href="/client/{{$client->id}}">
                        {{$client->name}}
                    </a>
                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>

                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <span class="color_pink">   @lang('variables.address')</span> : {{$client->address}}
                        </div>
                        <div class="col-lg-6 ">
                            <span class="color_pink">   @lang('variables.phone')</span> : {{$client->phone}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <span class="color_pink">   @lang('variables.trading_name')</span> : {{$client->trading_name}}
                        </div>
                        <div class="col-lg-6 ">
                            <span class="color_pink">   @lang('variables.trading_address')</span> : {{$client->trading_address}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            {{--<span class="color_pink">   @lang('variables.date')</span> : {{$client->date}}--}}
                        </div>
                        <div class="col-lg-6 ">
                            <span class="color_pink">   @lang('variables.date')</span> : {{$client->date->format('d-m-Y')}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 ">
                        </div>
                        <div class="col-lg-6">
                            <div class="col-lg-12">
                                <span class="color_pink">   @lang('variables.representative')</span> : {{$client->representative->name  or Lang::get('variables.not_found')}}
                            </div >
                            <div class="col-lg-12">

                                <span class="color_pink">   @lang('variables.phone')</span> : {{$client->representative->phone  or Lang::get('variables.not_found')}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2"></div>
    </div>
@stop