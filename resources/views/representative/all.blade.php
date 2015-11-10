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
                                    <a href="{{ URL::action('RepresentativesController@index')}}/{{$representative->id}}"> @lang('variables.show')</a>
                                    <a href="{{ URL::action('RepresentativesController@index')}}/{{$representative->id}}/edit">@lang('variables.edit')</a>
                                    @if(Auth::user()->type=='admin')
                                        <a href="{{ URL::action('RepresentativesController@index')}}/{{$representative->id}}/delete">@lang('variables.delete')</a>
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
    {{--<script src="{{ URL::asset('js/searchRepresentative.js')}}"></script>--}}
    <script>
        $(document).ready(function () {

            function sendData() {
                $.post('{{ URL::action('RepresentativesController@search')}}',
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
                                toShow+='<a href="{{ URL::action('RepresentativesController@index')}}/'+result.data[i].id+'">'+'عرض'+'</a>';
                                toShow+=' <a href="{{ URL::action('RepresentativesController@index')}}/'+result.data[i].id+'/edit">'+'تعديل'+'</a>';
                                if($('#U_type').val()=='admin')
                                {
                                    toShow+=' <a href="{{ URL::action('RepresentativesController@index')}}/'+result.data[i].id+'/delete">'+'مسح'+'</a>';
                                }
                                toShow+='</td>';
                                toShow+='<td>'+result.data[i].phone+'</td>';
                                toShow+='<td>'+result.data[i].name+'</td>';
                                toShow+='<td>'+result.data[i].id+'</td>';
                                toShow+='</tr>';
                            }
                            $('#result').html(toShow);
                            $('#render').html(result.render);
                            //console.log();

                        });
            };
            $('#submit').click(function () {
                sendData()
            });
            $('#query').keyup(function () {
                sendData()
            });
        });
    </script>
@stop