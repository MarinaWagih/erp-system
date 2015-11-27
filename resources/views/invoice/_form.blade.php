{{--===================Errors===============================--}}
{{--========================================================--}}
<div>
    <div class="percentage" id="msg">
    @if(count($errors) > 0)
            <div class="alert alert-danger" id="msg">
            <strong>@lang('variables.there_is_an_error')</strong>
            @lang('variables.make_it_right')
            @lang('variables.and')
            @lang('variables.try_again')
            @foreach ($errors->all() as $key=>$error)
                <div>
                    @if(str_contains($error,'date'))
                        @lang('variables.date')
                    @elseif(str_contains($error,'client'))
                        @lang('variables.El-client')
                    @endif
                    @if(str_contains($error,'required'))
                        @lang('variables.required')
                    @elseif(str_contains($error,'not a valid'))
                        @lang('variables.not_a_valid')
                    @endif
{{--                                            {{$error}}--}}
                </div>

            @endforeach
</div>
    @endif
    </div>
</div>
{{--===================Form=================================--}}
{{--========================================================--}}
<div class="form-group">
    {!! Form::label('date',$date) !!}
    {!! Form::input('date','date',null,['class'=>'form-control','id'=>'date',]) !!}
</div>
<div class="form-group">
    {!! Form::label('client',$client) !!}
    {!! Form::select('client_id',[],null,['class'=>'js-example-rtl form-control','id'=>'clients']) !!}
</div>
@if(Auth::user()->type=='admin')
<div class="checkbox">
    {!! Form::label('type',$buy,[]) !!}
    {!! Form::radio('type', 'buy',false,['id'=>'inv_type'])  !!}

    {!! Form::label('type',$sell,[]) !!}
    {!! Form::radio('type', 'sell',true,['id'=>'inv_type2'])  !!}

</div>
@else
{!! Form::hidden('type', 'sell', []) !!}
@endif
<div class="form-group">
    {!! Form::label('price_type',$price) !!}
    <select id="price_type" class="form-control" name="price_type">
        <option value="price_1050" {{isset($invoice->price_type)&&$invoice->price_type=='price_1050'?'selected':''}}>1050 {{$price}}</option>
        <option value="price_1250" {{isset($invoice->price_type)&&$invoice->price_type=='price_1250'?'selected':''}}>1250 {{$price}}</option>
        <option value="price_1034" {{isset($invoice->price_type)&&$invoice->price_type=='price_1034'?'selected':''}}>1034 {{$price}}</option>
        @if(isseT($invoice)&&$invoice->type=='buy')
            <option value="price_31_a" {{isset($invoice->price_type)&&$invoice->price_type=='price_31_a'?'selected':''}}>a 31 {{$price}}</option>
            <option value="price_32_b" {{isset($invoice->price_type)&&$invoice->price_type=='price_32_a'?'selected':''}}>b 32 {{$price}}</option>
        @endif
    </select>
</div>
<div class="form-group">
    <label  for="exampleInputAmount">@lang('variables.discount')</label>
    <div class="input-group">
        <div class="input-group-addon">%</div>
        <input type="number" class="form-control" id="discount_percentage"
               placeholder="@lang('variables.percentage') @lang('variables.discount')"
               min="0" max="28" value="20">
        <div class="input-group-addon">.00</div>
    </div>
</div>
<div class="form-group">
    <label  for="exampleInputAmount"> @lang('variables.duration') @lang('variables.expire') </label>
    <div class="input-group">
        <div class="input-group-addon">@lang('variables.day')</div>
        <input type="number" name="duration_expire" class="form-control" id="duration_expire" placeholder="" min="0" value="{{isset($invoice)?$invoice->duration_expire:0}}">
        {{--<div class="input-group-addon">12:00</div>--}}
    </div>
</div>
{{--================== Item Form button luncher=============--}}
{{--========================================================--}}
<!-- Button trigger modal -->
<button type="button" class="btn color"
        data-toggle="modal" data-target="#itemFormModel">
    @lang('variables.add') @lang('variables.items')
</button>
{{--========================================================--}}
{{--========================================================--}}
{{--====================items Form Model====================--}}
{{--========================================================--}}
<!-- Modal -->
<div class="modal fade" id="itemFormModel"
     role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title" id="myModalLabel">
                    @lang('variables.add') @lang('variables.item')
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('item',$item) !!}
                    <br>
                    {!! Form::select('item_id',[],null,['class'=>'js-example-rtl form-control','id'=>'items_list']) !!}
                </div>


                <div class="form-group">
                    {!! Form::label('quantity',$quantity) !!}
                    {!! Form::input('number','quantity',0,['class'=>'form-control','id'=>'quantity','min'=>'0']) !!}
                </div>
                <div class="form-group" id="price">
                    {!! Form::label('price',$price) !!}
                    {!! Form::input('number','price',0,['class'=>'form-control','id'=>'item_price','min'=>'0','step'=>"0.1",'disabled']) !!}
                </div>
                <div class="form-group">

                    <div id="total_after_discount">
                    <h1 class="color_pink title3">
                        <span id="total_item"> 0</span>  : @lang('variables.the_total')

                    </h1>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                    @lang('variables.cancel')
                </button>
                <button type="button" class="btn color" id="item_add_end">
                    @lang('variables.adding') @lang('variables.and') @lang('variables.end')
                </button>
                <button type="button" class="btn color" id="item_add">
                    @lang('variables.add')
                </button>
            </div>
        </div>
    </div>
</div>
{{--========================================================--}}
{{--========================================================--}}

{{--==================Items show table======================--}}
{{--========================================================--}}
<table class="table table-hover table-responsive">
    <thead>
    <tr>
        <th>@lang('variables.operations')</th>
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
                <td class="delete_item" id="x-{{$item->id}}"> @lang('variables.delete') </td>
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
{{--========================================================--}}
{{--========================================================--}}

{{--===================calculations=========================--}}
{{--========================================================--}}
<div class="row">
<div class="col-lg-1"></div>
<div class="col-lg-10">
    <div class="row final_calc">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="checkbox">
                <label for="taxes" style="margin-right:20px;"> Taxes</label>
                <input id="tax_check" type="checkbox">
            </div>
            <span id="Total_after_taxes">0.000</span>
        </div>
        {{--========================================================--}}
        {{--========================================================--}}
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
            <div class="row">
                {{--col-lg-4 col-md-4 col-sm-4 col-xs-4 --}}
                {{--col-lg-8 col-md-8 col-sm-8 col-xs-8--}}
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <input type="number" value="0" id="Total_invoice_discount" name="additional_discount_percentage" min="0" max="28" class="form-control input-sm">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <span class="color_dark title5">
                    @lang('variables.percentage')  @lang('variables.discount') @lang('variables.additional')
                </span>
                </div>

            </div>
            <div class="row">

                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <span id="additional_discount_value">
                   0.000
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
                    <span id="Total_additional_discount">0.000</span>
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
                    <span id="Total_invoice_before_discount">0.000</span>
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
                   20%
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
                    <span id="Total_invoice_after_discount">0.000</span>
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
<br>
{{--========================================================--}}
{{--========================================================--}}
<div class="form-group">
    {!! Form::hidden('items','',['id'=>'items']) !!}
    {!! Form::hidden('total_after_sales_tax','',['id'=>'total_after_sales_tax']) !!}
    {!! Form::submit($submitText,['class'=>'btn color','id'=>'submit']) !!}
</div>
