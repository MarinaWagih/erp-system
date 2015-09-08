@extends('app')
@section('title')
    @lang('variables.representatives')
@stop
@section('content')
    <div class="row masafa">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <input id="_token" type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="col-lg-2">
                <button id="submit" type="submit" class="btn color">@lang('variables.search')</button>

            </div>
            <div class="col-lg-10">
                <div class="form-group">
                    <input id="query" name="query" type="text" class="form-control"
                           placeholder="@lang('variables.search')">
                </div>
            </div>

        </div>

        <div class="col-lg-2"></div>
    </div>
    <div class="row">

            <div class="center">
                <table class="table table-hover">
                    <caption class="color_pink title3">@lang('variables.representatives')</caption>
                    <thead>
                    <tr>
                        <th>@lang('variables.operations')</th>
                        <th>@lang('variables.phone')</th>
                        <th>@lang('variables.name')</th>
                        <th>@lang('variables.number')</th>
                    </tr>
                    </thead>
                    <tbody id="result">
                    @if(isset($representatives))
                        @foreach($representatives as $representative)
                            <tr>
                                <td>
                                    <a href="/representative/{{$representative->id}}"> @lang('variables.show')</a>
                                    <a href="/representative/{{$representative->id}}/edit">@lang('variables.edit')</a>
                                    @if(Auth::user()->type=='admin')
                                        <a href="/representative/{{$representative->id}}/delete">@lang('variables.delete')</a>
                                    @endif
                                </td>
                                <td>{{$representative->phone}}</td>
                                <td>{{$representative->name}}</td>
                                <th scope="row">{{$representative->id}}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="center" id="render">

                    {!!$representatives->render()!!}

                </div>
                <input id="U_type" type="hidden" value="{{Auth::user()->type}}">
                @endif
            </div>

    </div>
@stop
@section('js')
    <script src="{{ URL::asset('js/searchRepresentative.js')}}"></script>
@stop