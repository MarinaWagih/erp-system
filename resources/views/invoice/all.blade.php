@extends('app')
@section('title')
    @lang('variables.invoices')
@stop
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/jquery-ui/jquery-ui.min.css')}}">
@stop
@section('content')
    <div class="row masafa">
        <div class="col-xs-2"></div>
        <div class="col-xs-8">
          <input id="_token" type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="col-xs-2">
                <button id="submit" type="submit" class="btn color">@lang('variables.search')</button>

            </div>
            <div class="col-xs-10">
                <div class="form-group">
                    <input id="query" name="query" type="text" class="form-control"
                           placeholder="@lang('variables.search') @lang('variables.with_client_name') ">
                    <br>
                    <input id="query_id" name="query_id" type="number" class="form-control"
                          min="0" placeholder="@lang('variables.search') @lang('variables.with_invoice_id')">
                    <br>
                    <input id="query_date" name="query_date" type="date"
                           class="form-control">
                </div>
            </div>

        </div>
        <div class="col-xs-2"></div>
    </div>
    <div class="row">

            <div class="center">
                <table class="table table-hover">
                    <caption class="color_pink title3">@lang('variables.invoices')</caption>
                    <thead>
                    <tr>
                        <th class="myth">@lang('variables.operations')</th>
                        <th class="myth">@lang('variables.date')</th>
                        <th class="myth">@lang('variables.client')</th>
                        <th class="myth">@lang('variables.invoice')</th>
                        <th class="myth">@lang('variables.number')</th>

                    </tr>
                    </thead>
                    <tbody id="result">
                    @if(isset($invoices))
                        {{--{{$invoices}}--}}
                        @foreach($invoices as $invoice)
                            <tr>
                                <td class="td20">
                                    <a href="{{ URL::action('InvoiceController@index')}}/{{$invoice->id}}"> @lang('variables.show')</a>
                                    <a href="{{ URL::action('InvoiceController@index')}}/{{$invoice->id}}/edit">@lang('variables.edit')</a>
                                    @if(Auth::user()->type=='admin')
                                        <a href="{{ URL::action('InvoiceController@index')}}/{{$invoice->id}}/delete">@lang('variables.delete')</a>
                                    @endif
                                </td>
                                <td class="td20">{{$invoice->date}}</td>
                                <td class="td20">{{{$invoice->client->name}}}</td>
                                <td class="td20">
                                    @if($invoice->installation=='1')
                                        @lang('variables.with_installation')
                                    @else
                                        @lang('variables.without_installation')
                                    @endif
                                </td >
                                <th scope="row" class="td20">{{$invoice->id}}</th>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                @if(isset($invoices))
                <div class="center" id="render">
                    {!!$invoices->render()!!}

                </div>
                @endif
            <input id="U_type" type="hidden" value="{{Auth::user()->type}}">

            </div>
        </div>

@stop
@section('js')
    {{--<script src="{{ URL::asset('/js/searchInvoice.js')}}"></script>--}}
    <script src="{{URL::asset('/jquery-ui/jquery-ui.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            //date picker
            $(function () {
                $("#query_date").datepicker({
                    dateFormat: 'yy-mm-dd'
                });
//                        .datepicker('setDate', new Date());
            });

            function sendData()
            {
                console.log($('#query').val(),$('#query_date').val(),$('#query_id').val());
                $.post('{{ URL::action('InvoiceController@search')}}',
                        {
                            'query':$('#query').val(),
                            'query_date':$('#query_date').val(),
                            'query_id':$('#query_id').val(),
                            '_token':$('#_token').val(),
                            'type':'json'
                        },
                        function(result){
                            var count=result.length;
                            console.log(result);
                            var toShow="";
                            for(var i=0;i<count;i++)
                            {
                                toShow+='<tr>' ;
                                toShow+='<td class="td20">';
                                toShow+='<a href="{{ URL::action('InvoiceController@index')}}/'+result[i].id+'">'+'@lang('variables.show')'+'</a>';
                                toShow+=' <a href="{{ URL::action('InvoiceController@index')}}/'+result[i].id+'/edit">'+'@lang('variables.edit')'+'</a>';
                                if($('#U_type').val()=='admin')
                                {
                                    toShow+=' <a href="{{ URL::action('InvoiceController@index')}}/'+result[i].id+'/delete">'+'@lang('variables.delete')'+'</a>';
                                }
                                //console.log(result[i]);
                                toShow+='</td>';
                                toShow+='<td class="td20">'+result[i].date+'</td>';
                                toShow+='<td class="td20">'+result[i].client.name+'</td>';
                                toShow+='<td class="td20">';
                                if(result[i].installation=='1')
                                {
                                    toShow+='@lang('variables.with_installation')'  ;
                                }
                                else
                                {
                                    toShow+='@lang('variables.without_installation')';
                                }
                                toShow+='</td>';
                                toShow+='<td class="td20">'+result[i].id+'</td>';
                                toShow+='</tr>';
                            }
                            $('#result').html(toShow);
                            $('#render').html('');
                            //console.log();

                        });
            }
            $('#submit').click(function () {
                sendData()
            });
//            $('#query').keyup(function () {
//                sendData()
//            });
        });
    </script>
@stop