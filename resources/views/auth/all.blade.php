@extends('app')
@section('title')
    @lang('variables.users')
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
                    <caption class="color_pink title3">@lang('variables.users')</caption>
                    <thead>
                    <tr>
                        <th class="myth">@lang('variables.operations')</th>
                        <th class="myth">@lang('variables.type')</th>
                        <th class="myth">@lang('variables.user_name')</th>
                        <th class="myth">@lang('variables.name')</th>
                        {{--<th>@lang('variables.number')</th>--}}
                    </tr>
                    </thead>
                    <tbody id="result">
                    @if(isset($users))
                        @foreach($users as $user)
                            <tr>
                                <td class="td20">
                                    @if(Auth::user()->type=='admin')
                                        <a href="{{ URL::action('HomeController@user_all')}}/{{$user->id}}/edit">@lang('variables.edit')</a>
                                        <a href="{{ URL::action('HomeController@user_all')}}/{{$user->id}}/delete">@lang('variables.delete')</a>
                                    @endif
                                </td>
                                <td  class="td20">{{$user->type=='user'?Lang::get('variables.customer_support'):Lang::get('variables.'.$user->type)}}</td>
                                <td  class="td20">{{$user->email}}</td>
                                <td  class="td20">{{$user->name}}</td>
                                {{--<th scope="row">{{$user->id}}</th>--}}
                            </tr>
                        @endforeach
                    @endif
                    </tbody>

                </table>
                <div class="center" id="render">

                    {!!$users->render()!!}

                </div>
                <input id="U_type" type="hidden" value="{{Auth::user()->type}}">

            </div>

    </div>
@stop
@section('js')
    <script>
        $(document).ready(function () {

            function sendData() {
                $.post('{{ URL::action('HomeController@user_search')}}',
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
                                var type_in=result.data[i].type;
                                var type='';
                                switch (type_in)
                                {
                                    case 'user':
                                        type='خدمة العملاء';
                                        break;
                                    case 'admin':
                                        type='أدمن';
                                        break;
                                    case 'representative':
                                        type='المندوب';
                                        break;

                                }
                                toShow+='<tr>' ;
                                toShow+='<td  class="td20">';
                                toShow+=' <a href="{{ URL::action('HomeController@user_all')}}/'+result.data[i].id+'/edit">'+'تعديل'+'</a>';
                                toShow+=' <a href="{{ URL::action('HomeController@user_all')}}/'+result.data[i].id+'/delete">'+'مسح'+'</a>';
                                toShow+='</td>';
                                toShow+='<td  class="td20">'+type+'</td>';
                                toShow+='<td  class="td20">'+result.data[i].email+'</td>';
                                toShow+='<td  class="td20">'+result.data[i].name+'</td>';
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