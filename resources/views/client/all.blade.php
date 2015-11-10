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
            <input id="search_link" type="hidden" name="search_link" value="{{ URL::action('ClientsController@search') }}">

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
                                    <a href='{{ URL::action('ClientsController@index') }}/{{$client->id}}'>
                                        @lang('variables.show')
                                    </a>
                                    <a href="{{ URL::action('ClientsController@index')}}/{{$client->id}}/edit">
                                        @lang('variables.edit')</a>
                                    @if(Auth::user()->type=='admin')
                                        <a href="{{ URL::action('ClientsController@index')}}/{{$client->id}}/delete">@lang('variables.delete')</a>
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
    <script>
        $(document).ready(function () {

            function sendData()
            {
                $.post("{{ URL::action('ClientsController@search') }}",
                        {
                            'query':$('#query').val(),
                            '_token':$('#_token').val(),
                            'type':'json'
                        },
                        function(result){
                            var count=result.data.length;
                            var toShow="";
                            for(var i=0;i<count;i++)
                            {
                                toShow+='<tr>' ;
                                toShow+='<td>';
                               var link_show="{{URL::action('ClientsController@index')}}"+'/'+result.data[i].id ;
                               var link_edit="{{URL::action('ClientsController@index')}}"+'/'+result.data[i].id+'/edit';
                               var link_delete=window.location.href+'/'+result.data[i].id+'/delete';

                                toShow+='<a href="'+link_show+'")>'+"@lang('variables.show')"+'</a>';
                                toShow+=' <a href="'+link_edit+'">'+"@lang('variables.edit')"+'</a>';
                                if($('#U_type').val()=='admin')
                                {
                                    toShow+=' <a href="'+link_delete+'">'+"@lang('variables.delete')"+'</a>';
                                }
                                toShow+='</td>';
                                toShow+='<td>'+result.data[i].trading_name+'</td>';
                                toShow+='<td>'+result.data[i].phone+'</td>';
                                toShow+='<td>'+result.data[i].name+'</td>';
                                toShow+='<td>'+result.data[i].id+'</td>';
                                toShow+='</tr>';
                            }
                            $('#result').html(toShow);
                            $('#render').html(result.render);
                            //console.log();

                        });
            }
            $('#submit').click(function () {
                sendData()
            });
            $('#query').keyup(function () {
                sendData()
            });
        });

    </script>
@stop