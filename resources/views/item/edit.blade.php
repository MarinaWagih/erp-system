@extends('app')
@section('title')
    New item
@stop
@section('content')

<div class="col-lg-2"></div>
<div class="col-lg-8">
    <h1>@lang('variables.edit') @lang('variables.info') {{$item->name}}</h1>
    <hr>
    {!! Form::model($item,['url'=>'item/'.$item->id,'method'=>'PUT','files'=>true])!!}
        @include('item._form',['submitText'=> Lang::get('variables.edit'),
                                 'name'   =>Lang::get('variables.name'),
                                 'write'  =>Lang::get('variables.write'),
                                 'price'  =>Lang::get('variables.price'),
                                 'code'  =>Lang::get('variables.code'),
                                 'picture'=>Lang::get('variables.picture')])
    {!! Form::close()!!}
</div>
@stop