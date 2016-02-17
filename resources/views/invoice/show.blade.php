@extends('app')

@section('css')
    <link rel="stylesheet" media="print" type="text/css" href="{{ URL::asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" media="print" type="text/css" href="{{ URL::asset('css/bootstrap-theme.min.css')}}">
    <link rel="stylesheet" media="print" type="text/css" href="{{ URL::asset('css/ar.css')}}">

@stop
@section('title')
    @lang('variables.invoice')  @lang('variables.number1')  {{$invoice->id}}
@stop
@section('content')
   <a
           href="{{ URL::action('InvoiceController@index')}}/{{$invoice->id}}/edit"
           class="btn color masafa" role="button" id="delete_x">@lang('variables.edit')</a>
    @if(Auth::user()->type=='admin')
        <a href="{{ URL::action('InvoiceController@index')}}/{{$invoice->id}}/delete"
           class="btn btn-danger masafa" id="edit_x" role="button">@lang('variables.delete')</a>
    @endif
    <button class="btn btn-warning masafa" id="print">@lang('variables.print')</button>
    <div class="wrapper"></div>
    <div class="masafa bg-logo" id="content">

        {{--===================id&& 2images=========================--}}
        {{--========================================================--}}
        <div class="row">
            <div class="left first">
                <br>
                <p class="title4">
                     @lang('variables.number1') @lang('variables.show') : {{$invoice->num($invoice->id)}}
                </p>
                <hr>
                <p class="title4">
                  @lang('variables.date') : {{$invoice->adate('j F Y',$invoice->date)}}
                </p>
            </div>
            <div class="left first">
                <img src="{{URL::asset('/logo.jpg')}}" class="show_img">
            </div>
            <div class="left first">
               <img src="{{URL::asset('/pic2.jpg')}}" class="show_img">
           </div>
       </div>
        {{--========================================================--}}
        {{--========================================================--}}
        <br>
        {{--===================Client data==========================--}}
        {{--========================================================--}}
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-9">
                <table class="table table-responsive table-bordered">
                    <tr class="right">
                        <td >{{{$invoice->client->name}}}</td>
                        <td> @lang('variables.name')  @lang('variables.client')</td>
                    </tr>
                    <tr class="right">
                        <td >{{{$invoice->client->address}}}</td>
                        <td> @lang('variables.address')  @lang('variables.client')</td>
                    </tr>
                    <tr class="right">
                        <td >{{{$invoice->num($invoice->client->mobile)}}}</td>
                        <td> @lang('variables.mobile')  @lang('variables.client')</td>
                    </tr>
                    <tr class="right">
                        <td >{{{$invoice->client->representative?$invoice->client->representative->name:''}}}</td>
                        {{--<td >{{{$invoice->client->representative->name}}}</td>--}}
                        <td> @lang('variables.representative') </td>
                    </tr>
                    <tr class="right">
                        @if($invoice->price_type=='price_1250')
                        <td>
                            @lang('variables.with_installation')
                            <span class="glyphicon glyphicon-check"></span>
                        </td>
                        <td>
                            @lang('variables.without_installation')
                            <span class="glyphicon glyphicon-unchecked"></span>
                        </td>
                         @elseif($invoice->price_type=='price_1050')
                            <td>
                                @lang('variables.with_installation')
                                <span class="glyphicon glyphicon-unchecked"></span>
                            </td>
                            <td>
                                @lang('variables.without_installation')
                                <span class="glyphicon glyphicon-check"></span>
                            </td>
                        @elseif($invoice->price_type=='price_1034')
                            <td>
                                @lang('variables.with_installation')
                                <span class="glyphicon glyphicon-unchecked"></span>
                            </td>
                            <td>
                                @lang('variables.without_installation')
                                <span class="glyphicon glyphicon-check"></span>
                            </td>
                        @elseif($invoice->price_type=='price_31_a')
                            <td>
                                @lang('variables.sell')
                                <span class="glyphicon glyphicon-unchecked"></span>
                            </td>
                            <td>
                                @lang('variables.buy')
                                <span class="glyphicon glyphicon-check"></span>
                            </td>
                        @elseif($invoice->price_type=='price_32_b')
                            <td>
                                @lang('variables.sell')
                                <span class="glyphicon glyphicon-unchecked"></span>
                            </td>
                            <td>
                                @lang('variables.buy')
                                <span class="glyphicon glyphicon-check"></span>
                            </td>
                        @endif


                    </tr>
                </table>
            </div>
            <div class="col-lg-1"></div>
        </div>
        {{--========================================================--}}
        {{--========================================================--}}
        {{--=====================Items==============================--}}
        {{--========================================================--}}
        <div class="row">
            {{--<div class="col-lg-0"></div>--}}
            <div class="col-lg-12">
                <table class="table table-bordered at_print" >
                    <thead>
                    <tr>
                        <th  class="myth">@lang('variables.the_total') @lang('variables.after') @lang('variables.discount')</th>
                        <th  class="myth">@lang('variables.price') @lang('variables.after') @lang('variables.discount')</th>
                        <th  class="myth">@lang('variables.percentage')  @lang('variables.discount')</th>
                        <th  class="myth">@lang('variables.price') @lang('variables.before') @lang('variables.discount')</th>
                        <th  class="myth">@lang('variables.quantity')</th>
                        <th  class="myth">@lang('variables.image')</th>
                        <th  class="myth">@lang('variables.name')</th>
                        {{--<th  class="myth">@lang('variables.number')</th>--}}
                    </tr>
                    </thead>
                    <tbody id="tableBody">
                    @if(isset($invoice))
                        @foreach($invoice->items as $key=>$item)
                            <tr id="{{$item->id}}" class="items_row">
                               <td class="td10">
                                    {{$invoice->num(($item->pivot->price-($item->pivot->price *$item->pivot->discount_percent)/100)*$item->pivot->quantity )}}
                                </td>
                                <td class="td10">
                                    {{$invoice->num($item->pivot->price-($item->pivot->price *$item->pivot->discount_percent)/100)  }}
                                </td>
                                <td class="td10">
                                    {{$invoice->num($item->pivot->discount_percent)}}
                                </td>
                                <td class="td10">
                                    {{ $invoice->num($item->pivot->price)  }}
                                </td>
                                <td class="td10">
                                    {{ $invoice->num($item->pivot->quantity)  }}
                                </td>
                                <td class="td10">
                                    @if($item->picture!='')
                                    <img src="{{URL::asset('images/'.$item->picture)}}" class="td10-image">
                                    {{--@else--}}
                                        {{--<span class="glyphicon glyphicon-ban-circle"></span>--}}
                                    @endif
                                </td>
                                <td class="td30">
                                    {{ $invoice->num($item->code ) }}
                                    <br>
                                    {{$invoice->num( $item->name ) }}
                                </td>
                            </tr>
                            @if((($key)!=0)&&(($key+1)%7==0)&&(($key+1)!==count($invoice->items)))
                            </tbody>
                            </table>
                            <div class="items_row_break"></div>
                            <table class="table table-bordered at_print" >
                                <thead >
                                <tr class="fe_el_nos_table">
                                    <th  class="myth">@lang('variables.the_total') @lang('variables.after') @lang('variables.discount')</th>
                                    <th  class="myth">@lang('variables.price') @lang('variables.after') @lang('variables.discount')</th>
                                    <th  class="myth">@lang('variables.percentage')  @lang('variables.discount')</th>
                                    <th  class="myth">@lang('variables.price') @lang('variables.before') @lang('variables.discount')</th>
                                    <th  class="myth">@lang('variables.quantity')</th>
                                    <th  class="myth">@lang('variables.image')</th>
                                    <th  class="myth">@lang('variables.name')</th>
                                    {{--<th  class="myth">@lang('variables.number')</th>--}}
                                </tr>
                                </thead>
                                <tbody id="tableBody">
                            @endif
                        @endforeach
                    @endif
                    </tbody>
                </table>

            </div>
            {{--<div class="col-lg-1"></div>--}}
        </div>
        {{--========================================================--}}
        {{--========================================================--}}
        {{--===================calculations=========================--}}
        {{--========================================================--}}
        <div class="row final_calc masafa" style="direction: rtl">
            <table class="table table-responsive" >
                <tr>
                    <td>@lang('variables.total') @lang('variables.price') @lang('variables.before') @lang('variables.discount')</td>
                    <td>{{$invoice->num($invoice->totalBeforeDiscount())}}  @lang('variables.eg_p')</td>
                    <td> @lang('variables.percentage')  @lang('variables.discount') @lang('variables.additional')</td>
                    <td> {{$invoice->num($invoice-> additional_discount_percentage.' %')}}</td>
                </tr>
                <tr>
                    <td>@lang('variables.total') @lang('variables.discount')</td>
                    <td>  {{$invoice->num($invoice->totalDiscount())}}  @lang('variables.eg_p')</td>
                    <td>  @lang('variables.value')  @lang('variables.discount') @lang('variables.additional')</td>
                    <td> {{$invoice->num($invoice->totalAfterDiscount()*
                    ($invoice-> additional_discount_percentage/100))}}  @lang('variables.eg_p')</td>
                </tr>
                <tr>
                    <td>  @lang('variables.total') @lang('variables.price') @lang('variables.after') @lang('variables.discount')</td>
                    <td> {{$invoice->num($invoice->totalAfterDiscount())}}  @lang('variables.eg_p')</td>
                    <td> @lang('variables.the_total')
                        @lang('variables.after')  @lang('variables.discount')
                        @lang('variables.additional')</td>
                    <td>{{$invoice->num($invoice->totalAfterDiscount()
                            -($invoice->totalAfterDiscount()*
                            ($invoice-> additional_discount_percentage/100)))}}  @lang('variables.eg_p')</td>
                </tr>
                <tr>
                    <td>
                        @if($invoice->total_after_sales_tax !=0)
                            <span class="glyphicon glyphicon-check"></span>
                        @else
                            <span class="glyphicon glyphicon-unchecked"></span>
                        @endif
                        @lang('variables.taxes')
                    </td>
                    <td>{{$invoice->num($invoice->total_after_sales_tax)}}  @lang('variables.eg_p')</td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
        {{--========================================================--}}
        {{--========================================================--}}
        <div class="row">
            <div class="col-xs-3">
                <p class="title5 right">
                    توقيع العميل
                </p>
            </div>
            <div class="col-xs-9">
                    <p class="title5 right">
                        نرجو أن يحوز العرض قبولكم
                    </p>
                    <p class="title5 right">
                        لا يعتد بهذا المستند إلا بأصل الفتورة معتمدة و مختومة من الشركة
                    </p>
            </div>
        </div>
    </div>

@stop
@section('js')
{{--    <script src="{{URL::asset('js/jquery-1.6.2.min.js')}}"></script>--}}
    <script src="{{URL::asset('js/jquery.PrintArea.js_4.js')}}"></script>
    <script src="{{URL::asset('js/core.js')}}"></script>
@stop