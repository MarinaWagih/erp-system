@extends('app')
@section('title')
    @lang('variables.invoices')
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
                    <caption class="color_pink title3">@lang('variables.invoices')</caption>
                    <thead>
                    <tr>
                        <th>@lang('variables.operations')</th>
                        <th>@lang('variables.date')</th>
{{--                        <th>@lang('variables.total')</th>--}}
                        <th>@lang('variables.invoice')</th>
                        <th>@lang('variables.number')</th>

                    </tr>
                    </thead>
                    <tbody id="result">
                    @if(isset($invoices))
                        {{--{{$invoices}}--}}
                        @foreach($invoices as $invoice)
                            <tr>
                                <td>
                                    <a href="/invoice/{{$invoice->id}}"> @lang('variables.show')</a>
                                    <a href="/invoice/{{$invoice->id}}/edit">@lang('variables.edit')</a>
                                    @if(Auth::user()->type=='admin')
                                        <a href="/invoice/{{$invoice->id}}/delete">@lang('variables.delete')</a>
                                    @endif
                                </td>
                                <td>{{$invoice->date}}</td>
{{--                                <td>{{$invoice->total()}}</td>--}}
                                <td>
                                    @if($invoice->installation=='1')
                                        @lang('variables.with_installation')
                                    @else
                                        @lang('variables.without_installation')
                                    @endif
                                </td>
                                <th scope="row">{{$invoice->id}}</th>
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
    <script src="{{ URL::asset('/js/searchInvoice.js')}}"></script>
@stop