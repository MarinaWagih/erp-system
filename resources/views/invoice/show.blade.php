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
    <button class="btn btn-warning masafa" id="print">@lang('variables.print')</button>
    <div class="wrapper"></div>
    <img src="{{URL::asset('/coloredLogo2.jpg')}}" class="bg_img">
    <div class="masafa bg-logo" id="content">

        {{--===================id&& 2images=========================--}}
        {{--========================================================--}}
        <div class="row">
            <div class="left first">
                <br>
                <br>
                <p class="title4">
                    {{$invoice->id}} : @lang('variables.number1') @lang('variables.show')
                </p>
                <hr>
                <p class="title4">
                    {{$invoice->date}} : @lang('variables.date')
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
                        <td >{{$invoice->client->name}}</td>
                        <td> @lang('variables.name')  @lang('variables.client')</td>
                    </tr>
                    <tr class="right">
                        <td >{{$invoice->client->address}}</td>
                        <td> @lang('variables.address')  @lang('variables.client')</td>
                    </tr>
                    <tr class="right">
                        <td >{{$invoice->client->phone}}</td>
                        <td> @lang('variables.mobile')  @lang('variables.client')</td>
                    </tr>
                    <tr class="right">
                        <td >{{$invoice->client->representative->name}}</td>
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
        <br>
        {{--=====================Items==============================--}}
        {{--========================================================--}}
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th>@lang('variables.the_total') @lang('variables.after') @lang('variables.discount')</th>
                        <th>@lang('variables.price') @lang('variables.after') @lang('variables.discount')</th>
                        <th>@lang('variables.percentage')  @lang('variables.discount')</th>
                        <th>@lang('variables.price') @lang('variables.before') @lang('variables.discount')</th>
                        <th>@lang('variables.quantity')</th>
                        <th>@lang('variables.image')</th>
                        <th>@lang('variables.name')</th>
                        <th>@lang('variables.number')</th>
                    </tr>
                    </thead>
                    <tbody id="tableBody">
                    @if(isset($invoice))
                        @foreach($invoice->items as $item)
                            <tr id="{{$item->id}}" class="items_row">
                               <td>
                                    {{($item->pivot->price-($item->pivot->price *$item->pivot->discount_percent)/100)*$item->pivot->quantity }}
                                </td>
                                <td>
                                    {{$item->pivot->price-($item->pivot->price *$item->pivot->discount_percent)/100  }}
                                </td>
                                <td>
                                    {{$item->pivot->discount_percent}}
                                </td>
                                <td>
                                    {{ $item->pivot->price  }}
                                </td>
                                <td>
                                    {{ $item->pivot->quantity  }}
                                </td>
                                <td>
                                    <img src="{{URL::asset('images/'.$item->picture)}}" style="height: 50px;width:50px">
                                </td>
                                <td>
                                    {{ $item->name  }}
                                </td>
                                <td>
                                    {{ $item->id }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>

            </div>
            <div class="col-lg-2"></div>
        </div>
        {{--========================================================--}}
        {{--========================================================--}}
        <br>
        {{--===================calculations=========================--}}
        {{--========================================================--}}
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-9">
            <div class="row final_calc">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <div class="checkbox">
                    <label for="taxes" style="margin-right:20px;"> Taxes</label>
                    @if($invoice->total_after_sales_tax !=0)
                        <span class="glyphicon glyphicon-check"></span>
                    @else
                        <span class="glyphicon glyphicon-unchecked"></span>
                    @endif

                </div>
                <span id="Total_after_taxes">{{$invoice->total_after_sales_tax}}</span>
            </div>
            {{--========================================================--}}
            {{--========================================================--}}
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <span id="additional_discount_value">
                            {{$invoice-> additional_discount_percentage}}%
                        </span>

                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                        <span class="color_dark title5">
                            @lang('variables.percentage')  @lang('variables.discount') @lang('variables.additional')
                        </span>
                    </div>

                </div>
                <div class="row">

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <span id="additional_discount_value">
                          {{$invoice->totalAfterDiscount()*($invoice-> additional_discount_percentage/100)}}
                        </span>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                        <span class="color_dark title5">
                            @lang('variables.value')  @lang('variables.discount') @lang('variables.additional')
                         </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <span id="Total_additional_discount">
                            {{$invoice->totalAfterDiscount()-($invoice->totalAfterDiscount()*($invoice-> additional_discount_percentage/100))}}
                        </span>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                <span class="color_dark title5">
                    @lang('variables.total') @lang('variables.price')
                    @lang('variables.after')  @lang('variables.discount')
                    @lang('variables.additional')
                </span>
                    </div>
                </div>
            </div>
            {{--========================================================--}}
            {{--========================================================--}}
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <span id="Total_invoice_before_discount">{{$invoice->totalBeforeDiscount()}}</span>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                        <span class="color_dark title5">
                            @lang('variables.total') @lang('variables.price') @lang('variables.before') @lang('variables.discount')
                        </span>
                    </div>

                </div>
                <div class="row">

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <span id="Total_invoice_discount">
                           {{$invoice->totalDiscount()}}
                        </span>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                        <span class="color_dark title5">
                            @lang('variables.total') @lang('variables.discount')
                        </span>
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <span id="Total_invoice_after_discount">
                            {{$invoice->totalAfterDiscount()}}
                        </span>
                    </div>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                <span class="color_dark title5">
                    @lang('variables.total') @lang('variables.price') @lang('variables.after') @lang('variables.discount')
                </span>
                    </div>
                </div>
            </div>
            </div>
        </div>
            <div class="col-lg-1"></div>
        </div>
        {{--========================================================--}}
        {{--========================================================--}}
        <div class="row">
            <div class="col-xs-3">
                <p class="title5">
                    توقيع العميل
                </p>
            </div>
            <div class="col-xs-9">
                    <p class="title5">
                        نرجو أن يحوز العرض قبولكم
                    </p>
                    <p class="title5">
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