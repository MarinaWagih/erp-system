@extends('app')
@section('title')
    @lang('variables.clients')
@stop
@section('content')
    <div class="row masafa">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            {{--<form class=" form-horizontal" role="search" method="POST" action="/client/search">--}}
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
            {{--</form>--}}

        </div>

        <div class="col-lg-2"></div>
    </div>
    <div class="row">

            <div class="center">
                <table class="table table-hover">
                    <caption class="color_pink title3">@lang('variables.clients')</caption>
                    <thead>
                    <tr>
                        <th>@lang('variables.operations')</th>
                        <th>@lang('variables.trading_name')</th>
                        <th>@lang('variables.phone')</th>
                        <th>@lang('variables.name')</th>
                        <th>@lang('variables.number')</th>

                    </tr>
                    </thead>
                    <tbody id="result">
                    @if(isset($clients))
                        @foreach($clients as $client)
                            <tr>
                                <td>
                                    <a href="/client/{{$client->id}}"> @lang('variables.show')</a>
                                    <a href="/client/{{$client->id}}/edit">@lang('variables.edit')</a>
                                    @if(Auth::user()->type=='admin')
                                        <a href="/client/{{$client->id}}/delete">@lang('variables.delete')</a>
                                    @endif
                                </td>
                                <td>{{$client->trading_name}}</td>
                                <td>{{$client->phone}}</td>
                                <td>{{$client->name}}</td>
                                <th scope="row">{{$client->id}}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="center" id="render">

                    {!!$clients->render()!!}

                </div>
            <input id="U_type" type="hidden" value="{{Auth::user()->type}}">
                @endif
            </div>
        </div>

@stop
@section('js')
    <script src="{{ URL::asset('/js/searchClient.js')}}"></script>
@stop