@extends('app')
@section('title')
    @lang('variables.edit') @lang('variables.info')  {{$invoice->name}}
@stop
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('/jquery-ui/jquery-ui.min.css')}}">
@stop
@section('content')

<div class="col-lg-2"></div>
<div class="col-lg-8">
    <h1>@lang('variables.edit') @lang('variables.info')  {{$invoice->name}} </h1>
    <hr>
    {!! Form::model($invoice,['url'=>'invoice/'.$invoice->id,'method'=>'PUT'])!!}
        @include('invoice._form',['submitText'=> Lang::get('variables.edit'),
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
    <script>
        $(function() {
            $( "#date" ).datepicker();
        });
    </script>
@stop