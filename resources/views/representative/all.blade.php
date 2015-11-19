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
<div class="col-xs-2"></div>
<div class="col-xs-8">
    <div class="center">
        <table class="table table-hover">
            <caption class="color_pink title3">@lang('variables.representatives')</caption>
            <thead>
            <tr>
                <th class="myth">@lang('variables.operations')</th>
                {{--<th>@lang('variables.phone')</th>--}}
                <th class="myth">@lang('variables.name')</th>
                <th class="myth">@lang('variables.user_name')</th>
                {{--<th>@lang('variables.number')</th>--}}
            </tr>
            </thead>
            <tbody id="result">
            @if(isset($representatives))
                @foreach($representatives as $representative)
                    <tr>
                        <td class="td10">
                            <a href="{{ URL::action('RepresentativesController@index')}}/{{$representative->id}}"> @lang('variables.show')</a>
                            @if(Auth::user()->type=='admin')
                                <a href="{{ URL::action('HomeController@user_all')}}/{{$representative->id}}/edit">@lang('variables.edit')</a>
                                <a href="{{ URL::action('RepresentativesController@index')}}/{{$representative->id}}/delete">@lang('variables.delete')</a>
                            @else
                                <a href="{{ URL::action('RepresentativesController@index')}}/{{$representative->id}}/edit">@lang('variables.edit')</a>
                                 @endif
                        </td>
                        {{--<td>{{$representative->phone}}</td>--}}
                        <td  class="td10">{{$representative->name}}</td>
                        <td  class="td10">{{$representative->email}}</td>
                        {{--                                <th scope="row">{{$representative->id}}</th>--}}
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
<div class="col-xs-2"></div>


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
                                toShow+='<td  class="td10">';
                                toShow+='<a href="{{ URL::action('RepresentativesController@index')}}/'+result.data[i].id+'">'+'عرض'+'</a>';
                                if($('#U_type').val()=='admin')
                                {
                                    toShow+=' <a href="{{ URL::action('HomeController@user_all')}}/'+result.data[i].id+'/edit">'+'تعديل'+'</a>';
                                    toShow+=' <a href="{{ URL::action('RepresentativesController@index')}}/'+result.data[i].id+'/delete">'+'مسح'+'</a>';

                                }
                                else
                                {
                                    toShow+=' <a href="{{ URL::action('RepresentativesController@index')}}/'+result.data[i].id+'/edit">'+'تعديل'+'</a>';
                                }
                                toShow+='</td>';
//                                toShow+='<td>'+result.data[i].phone+'</td>';
                                toShow+='<td  class="td10">'+result.data[i].name+'</td>';
                                toShow+='<td  class="td10">'+result.data[i].email+'</td>';
//                                toShow+='<td>'+result.data[i].id+'</td>';
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