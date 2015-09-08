@extends('app')
@section('title')
    @lang('variables.edit') @lang('variables.info')  {{$client->name}}
@stop
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('/jquery-ui/jquery-ui.min.css')}}">
@stop
@section('content')

<div class="col-lg-2"></div>
<div class="col-lg-8">
    <h1>@lang('variables.edit') @lang('variables.info')  {{$client->name}} </h1>
    <hr>
    {!! Form::model($client,['url'=>'client/'.$client->id,'method'=>'PUT'])!!}
        @include('client._form',['submitText'=> Lang::get('variables.edit'),
                                 'name'   =>Lang::get('variables.name'),
                                 'write'  =>Lang::get('variables.write'),
                                 'address'=>Lang::get('variables.address'),
                                 'phone'  =>Lang::get('variables.phone'),
                            'trading_name'=>Lang::get('variables.trading_name'),
                         'trading_address'=>Lang::get('variables.trading_address'),
                                 'date'   =>Lang::get('variables.date'),
                                 'mobile'=>Lang::get('variables.mobile'),
                                 'fax'=>Lang::get('variables.fax'),
                                 'email'=>Lang::get('variables.email'),
                          'representative'=>Lang::get('variables.representative'),

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