@extends('app')
@section('title')
    @lang('variables.hello')
@stop
@section('content')

        {{--<div class="col-lg-10">--}}
        {{--<div class="row" style="margin-top: 50px;">--}}
            {{--<div class="col-lg-6" >--}}

                {{--<a type="button" class="btn color_pink btn-lg btn-block" href="/representative">--}}

                    {{--<h1>--}}
                        {{--<span class="glyphicon glyphicon-user"></span>--}}
                        {{--<br>--}}
                        {{--@lang('variables.representatives')--}}
                    {{--</h1>--}}
                {{--</a>--}}
                {{--<a type="button" class="btn color btn-lg btn-block" href="/representative/create">--}}

                    {{--@lang('variables.add') @lang('variables.representative') <span class="glyphicon glyphicon-plus"></span>--}}
                {{--</a>--}}
            {{--</div>--}}

            {{--<div class="col-lg-6" >--}}

                {{--<a type="button" class="btn color_pink btn-lg btn-block" href="/client">--}}

                    {{--<h1>--}}
                        {{--<span class="glyphicon glyphicon-user"></span>--}}
                        {{--<br>--}}
                        {{--@lang('variables.clients')--}}
                    {{--</h1>--}}
                {{--</a>--}}
                {{--<a type="button" class="btn color btn-lg btn-block" href="/client/create">--}}

                    {{--@lang('variables.add') @lang('variables.client') <span class="glyphicon glyphicon-plus"></span>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}

            {{--@if(Auth::user()->type=='admin')--}}
                {{--<div class="row" style="margin-top: 50px;">--}}
                    {{--<div class="col-lg-3" ></div>--}}
                    {{--<div class="col-lg-6" >--}}

                        {{--<a type="button" class="btn color_pink btn-lg btn-block">--}}

                            {{--<h1>--}}
                                {{--<span class="glyphicon glyphicon-user"></span>--}}
                                {{--<br>--}}
                                {{--@lang('variables.users')--}}
                            {{--</h1>--}}
                        {{--</a>--}}
                        {{--<a type="button" class="btn color btn-lg btn-block"  href="/auth/register">--}}

                            {{--@lang('variables.add') @lang('variables.new_user') <span class="glyphicon glyphicon-plus"></span>--}}
                        {{--</a>--}}
                    {{--</div>--}}
                    {{--<div class="col-lg-3" ></div>--}}
                {{--</div>--}}
            {{--@endif--}}


    {{--</div>--}}
    {{--<div class="col-lg-2">--}}
       {{--<h2>--}}
           {{--@lang('variables.hello'),{{Auth::user()->email}}--}}
       {{--</h2>--}}
    {{--</div>--}}

    {{--<div class="col-lg-2"></div>--}}
@stop