@extends('app')
@section('title')
    {{$representative->name}}
@stop
@section('content')
    <div class="row">
        <div class="col-lg-2">
            <a href="/representative/{{$representative->id}}/edit">
                <h2 class="link">
                    @lang('variables.edit')
                    <span class="glyphicon glyphicon-edit"></span>

                </h2>
            </a>
            @if(Auth::user()->type=='admin')
                <a href="/representative/{{$representative->id}}/delete">
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

                    <a href="/client/{{$representative->id}}">
                        {{$representative->name}}
                    </a>
                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>

                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">

                        </div>
                        <div class="col-lg-6 ">
                            <span class="color_pink">   @lang('variables.phone')</span> : {{$representative->phone}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-2"></div>
    </div>
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="color title2 panel_title">


                        @lang('variables.clients')

                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>

                </div>
                <div class="panel-body">
                    @foreach($representative->clients as $client)
                        <div class="row">

                            <div class="col-lg-6 ">
                                <span class="color_pink">   @lang('variables.phone')</span> : {{$client->phone}}
                            </div>
                            <div class="col-lg-6">
                                <a href="/client/{{$client->id}}">
                                     <span class="color_pink">
                                    {{$client->name}}
                                </span>
                                </a>

                            </div>
                            <hr>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-2"></div>
    </div>
@stop