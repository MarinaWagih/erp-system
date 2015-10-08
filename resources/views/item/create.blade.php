@extends('app')
@section('title')
    @lang('variables.new') @lang('variables.item')
@stop
@section('content')

<div class="col-lg-2"></div>
<div class="col-lg-8">
    <h1>@lang('variables.add') @lang('variables.item')</h1>
    <hr>
    {!! Form::open(['url'=>'item','files'=>true])!!}
        @include('item._form',['submitText'=> Lang::get('variables.add'),
                                 'name'   =>Lang::get('variables.name'),
                                 'write'  =>Lang::get('variables.write'),
                                 'price'  =>Lang::get('variables.price'),
                                 'code'  =>Lang::get('variables.code'),
                                 'picture'=>Lang::get('variables.picture'),

                                 ])
    {!! Form::close()!!}
</div>
@stop