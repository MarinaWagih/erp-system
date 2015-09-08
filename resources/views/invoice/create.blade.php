@extends('app')
@section('title')
    @lang('variables.add') @lang('variables.invoice')
@stop
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/jquery-ui/jquery-ui.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/select2-bootstrap.css')}}">
@stop
@section('content')

<div class="col-lg-2"></div>
<div class="col-lg-8">
    <h1>@lang('variables.add') @lang('variables.invoice')</h1>
    <hr>
    {!! Form::open(['url'=>'invoice'])!!}
        @include('invoice._form',['submitText'=> Lang::get('variables.add'),
                                 'write'  =>Lang::get('variables.write'),
                                 'date'   =>Lang::get('variables.date'),
                                 'with_installation'=>Lang::get('variables.with_installation'),
                                 'without_installation'=>Lang::get('variables.without_installation'),
                                 'client'=>Lang::get('variables.client'),
                                 'item'=>Lang::get('variables.item'),
                                 'price'=>Lang::get('variables.price'),
                                 'quantity'=>Lang::get('variables.quantity'),

                                                                ])
    {!! Form::close()!!}

   </div>
@stop
@section('js')

    <script src="{{URL::asset('/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{URL::asset('/js/select2.min.js')}}"></script>
    <script src="{{URL::asset('/js/invoicePreparation.js')}}"></script>
@stop