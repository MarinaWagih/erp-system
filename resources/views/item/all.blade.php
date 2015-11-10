@extends('app')
@section('title')
    @lang('variables.items')
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
                    <caption class="color_pink title3">@lang('variables.items')</caption>
                    <thead>
                    <tr>
                        <th>@lang('variables.operations')</th>
                        <th>@lang('variables.price') 1050</th>
                        <th>@lang('variables.price') 1250</th>
                        <th>@lang('variables.price') 1034</th>
                        <th>@lang('variables.code')</th>
                        <th>@lang('variables.name')</th>
                        <th>@lang('variables.number')</th>
                    </tr>
                    </thead>
                    <tbody id="result">
                    @if(isset($items))
                        @foreach($items as $item)
                            <tr>
                                <td>
                                    <a href="{{ URL::action('ItemController@index')}}/{{$item->id}}"> @lang('variables.show')</a>

                                    @if(Auth::user()->type=='admin')
                                        <a href="{{ URL::action('ItemController@index')}}/{{$item->id}}/edit">@lang('variables.edit')</a>
                                        <a href="{{ URL::action('ItemController@index')}}/{{$item->id}}/delete">@lang('variables.delete')</a>
                                    @endif
                                </td>
                                <td>{{$item->price_1050}}</td>
                                <td>{{$item->price_1250}}</td>
                                <td>{{$item->price_1034}}</td>
                                <td>{{$item->code}}</td>
                                <td>{{$item->name}}</td>
                                <th scope="row">{{$item->id}}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="center" id="render">

                    {!!$items->render()!!}

                </div>
                <input id="U_type" type="hidden" value="{{Auth::user()->type}}">
                @endif
            </div>

    </div>
@stop
@section('js')
    {{--<script src="{{ URL::asset('js/searchItem.js')}}"></script>--}}
    <script>
        $(document).ready(function () {


            function sendData()
            {
                $.post('{{ URL::action('ItemController@search')}}',
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
                                toShow+='<a href="{{ URL::action('ItemController@index')}}/'+result.data[i].id+'">'+'عرض'+'</a>';
                                toShow+=' <a href="{{ URL::action('ItemController@index')}}/'+result.data[i].id+'/edit">'+'تعديل'+'</a>';
                                if($('#U_type').val()=='admin')
                                {
                                    toShow+=' <a href="{{ URL::action('ItemController@index')}}/'+result.data[i].id+'/delete">'+'مسح'+'</a>';
                                }
                                toShow+='</td>';
                                toShow+='<td>'+result.data[i].price_1050+'</td>';
                                toShow+='<td>'+result.data[i].price_1250+'</td>';
                                toShow+='<td>'+result.data[i].price_1034+'</td>';
                                toShow+='<td>'+result.data[i].code+'</td>';
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