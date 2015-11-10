@extends('app')
@section('title')
    @lang('variables.hello')
@stop
@section('content')
<br>
<br>
<br>
<br>

    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <img src="{{URL::asset('/coloredLogo.png')}}" class="bg_img">
        </div>
        <div class="col-lg-3"></div>
    </div>
@stop