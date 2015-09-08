{{--===================Errors===============================--}}
{{--========================================================--}}
<div>
    @if(count($errors) > 0)
        <div class="percentagealert alert-danger">
            <strong>@lang('variables.there_is_an_error')</strong>
            @lang('variables.make_it_right')
            @lang('variables.and')
            @lang('variables.try_again')
            @foreach ($errors->all() as $key=>$error)
                <div>
                    @if(str_contains($error,'trading name'))
                        @lang('variables.trading_name')
                    @elseif(str_contains($error,'trading address'))
                        @lang('variables.trading_address')
                    @elseif(str_contains($error,'address'))
                        @lang('variables.address')
                    @elseif(str_contains($error,'phone'))
                        @lang('variables.phone')
                    @elseif(str_contains($error,'name'))
                        @lang('variables.name')
                    @elseif(str_contains($error,'date'))
                        @lang('variables.date')
                    @elseif(str_contains($error,'mobile'))
                        @lang('variables.mobile')
                    @elseif(str_contains($error,'fax'))
                        @lang('variables.fax')
                    @elseif(str_contains($error,'email'))
                        @lang('variables.email')
                    @endif
                    @if(str_contains($error,'required'))
                        @lang('variables.required')
                    @elseif(str_contains($error,'match'))
                        @lang('variables.do_not') @lang('variables.match')
                    @elseif(str_contains($error,'at least 11'))
                        @lang('variables.at_least_11')
                    @elseif(str_contains($error,'taken'))
                        @lang('variables.taken')
                    @elseif(str_contains($error,'not a valid'))
                        @lang('variables.not_a_valid')
                    @endif
{{--                                            {{$error}}--}}
                </div>

            @endforeach
        </div>

    @endif
</div>
{{--===================Form=================================--}}
{{--========================================================--}}
<div class="form-group">
    {!! Form::label('date',$date) !!}
    {!! Form::input('date','date',date('Y-m-d'),['class'=>'form-control','id'=>'date']) !!}
</div>
<div class="form-group">
    {!! Form::label('client',$client) !!}
    {!! Form::select('client_id',[],null,['class'=>'js-example-rtl form-control','id'=>'clients']) !!}
</div>
{{--<select class="js-data-example-ajax">--}}
    {{--<option value="3620194" selected="selected">select2/select2</option>--}}
{{--</select>--}}
<div class="checkbox">
    {{--================== Item Form button luncher=============--}}
    {{--========================================================--}}
    <!-- Button trigger modal -->
        <button type="button" class="btn color"
                data-toggle="modal" data-target="#itemFormModel">
           @lang('variables.add') @lang('variables.items')
        </button>
    {{--========================================================--}}
    {{--========================================================--}}
    {!! Form::label('installation',$with_installation,[]) !!}
    {!! Form::radio('installation', 1,true,[])  !!}

    {!! Form::label('installation',$without_installation,[]) !!}
    {!! Form::radio('installation', 0 ,false,[])  !!}


{{--==================== Items Formmodel======================--}}
{{--========================================================--}}
</div>
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
               {!! Form::text('items',null,['id'=>'items','hidden'=>true]) !!}

                <div class="form-group">
                    {!! Form::label('quantity',$quantity) !!}
                    {!! Form::input('number','quantity',0,['class'=>'form-control','id'=>'quantity','min'=>'0']) !!}
                </div>
                <div class="form-group" id="price">
                    {!! Form::label('price',$price) !!}
                    {!! Form::input('number','price',0,['class'=>'form-control','id'=>'item_price','min'=>'0']) !!}
                </div>
                <div class="form-group">
                    <label  for="exampleInputAmount">@lang('variables.discount')</label>
                    <div class="input-group">
                        <div class="input-group-addon">%</div>
                        <input type="number" class="form-control" id="discount_percentage" placeholder="@lang('variables.percentage') @lang('variables.discount')" min="0">
                        <div class="input-group-addon">.00</div>
                    </div>
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
                    @lang('variables.logout')
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
<table class="table table-hover">
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
            <tr id="item-{{$item->id}}" class="items_row">
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
                    <img src="{{URL::asset('images/'.$item->picture)}}">
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
<div class="row final_calc">
     <div class="col-lg-6">
         <div class="row">
             <div class="col-lg-6">
                 <span id="Total_invoice_before_discount">10</span>
             </div>
             <div class="col-lg-6">
                <span class="color_dark title5">
                    @lang('variables.percentage')  @lang('variables.discount') @lang('variables.additional')
                </span>
             </div>

         </div>
         <div class="row">
             <div class="col-lg-6">
                <span id="Total_invoice_discount">
                    {{--{{$invoice->totalbefored()}}--}}
                </span>
             </div>
             <div class="col-lg-6">
                <span class="color_dark title5">
                    @lang('variables.value')  @lang('variables.discount') @lang('variables.additional')
                 </span>
             </div>
         </div>
         <div class="row">
             <div class="col-lg-6">
                 <span id="Total_invoice_after_discount"></span>
             </div>
             <div class="col-lg-6">
                <span class="color_dark title5">
                    @lang('variables.total') @lang('variables.price')
                    @lang('variables.after')  @lang('variables.discount')
                    @lang('variables.additional')
                </span>
             </div>
         </div>
     </div>
    <div class="col-lg-6">
        <div class="row">
            <div class="col-lg-6">
                <span id="Total_invoice_before_discount">10</span>
            </div>
            <div class="col-lg-6">
                <span class="color_dark title5">
                    @lang('variables.total') @lang('variables.price') @lang('variables.before') @lang('variables.discount')
                </span>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-6">
                <span id="Total_invoice_discount">
                    {{--{{$invoice->totalbefored()}}--}}
                </span>
            </div>
            <div class="col-lg-6">
                <span class="color_dark title5">
                    @lang('variables.total') @lang('variables.discount')
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <span id="Total_invoice_after_discount"></span>
            </div>
            <div class="col-lg-6">
                <span class="color_dark title5">
                    @lang('variables.total') @lang('variables.price') @lang('variables.after') @lang('variables.discount')
                </span>
            </div>
        </div>
    </div>
</div>
<br>
{{--========================================================--}}
{{--========================================================--}}
<div class="form-group">
    {!! Form::submit($submitText,['class'=>'btn color']) !!}
</div>
