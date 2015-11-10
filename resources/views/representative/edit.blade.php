@extends('app')
@section('title')
    New representative
@stop
@section('content')

<div class="col-lg-2"></div>
<div class="col-lg-8">
    <h1> <h1>@lang('variables.edit') @lang('variables.info') {{$representative->name}}</h1>
    <hr>
    {!! Form::model($representative,['url'=>'representative/'.$representative->id,'method'=>'PUT'])!!}
        @include('representative._form',['submitText'=> Lang::get('variables.edit'),
                                 'name'   =>Lang::get('variables.name'),
                                 'write'  =>Lang::get('variables.write'),
                                 'phone'  =>Lang::get('variables.phone'),])
    {!! Form::close()!!}
</div>
@stop