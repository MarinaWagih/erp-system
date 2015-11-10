@extends('app')
@section('title')
    @lang('variables.new') @lang('variables.representative1')
@stop
@section('content')

<div class="col-lg-2"></div>
<div class="col-lg-8">
    <h1>@lang('variables.add') @lang('variables.representative1')</h1>
    <hr>
    {!! Form::open(['url'=>'representative'])!!}
        @include('representative._form',['submitText'=> Lang::get('variables.add'),
                                 'name'   =>Lang::get('variables.name'),
                                 'write'  =>Lang::get('variables.write'),
                                 'phone'  =>Lang::get('variables.phone'),])
    {!! Form::close()!!}
</div>
@stop