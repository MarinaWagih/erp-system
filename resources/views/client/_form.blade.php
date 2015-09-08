{{--Errors--}}
<div>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
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
{{--Form--}}
<div class="form-group">
    {!! Form::label('name',$name) !!}
    {!! Form::text('name',null,['class'=>'form-control','placeholder'=>$write.' '.$name ]) !!}
</div>
<div class="form-group">
    {!! Form::label('address',$address) !!}
    {!! Form::text('address',null,['class'=>'form-control','placeholder'=>$write.' '.$address]) !!}
</div>
<div class="form-group">
    {!! Form::label('phone',$phone) !!}
    {!! Form::text('phone',null,['class'=>'form-control','placeholder'=>$write.' '.$phone]) !!}
</div>
<div class="form-group">
    {!! Form::label('mobile',$mobile) !!}
    {!! Form::text('mobile',null,['class'=>'form-control','placeholder'=>$write.' '.$mobile]) !!}
</div>
<div class="form-group">
    {!! Form::label('fax',$fax) !!}
    {!! Form::text('fax',null,['class'=>'form-control','placeholder'=>$write.' '.$fax]) !!}
</div>
<div class="form-group">
    {!! Form::label('email',$email) !!}
    {!! Form::email('email',null,['class'=>'form-control','placeholder'=>$write.' '.$email]) !!}
</div>
<div class="form-group">
    {!! Form::label('trading_name',$trading_name) !!}
    {!! Form::text('trading_name',null,['class'=>'form-control','placeholder'=>$write.' '.$trading_name]) !!}
</div>
<div class="form-group">
    {!! Form::label('trading_address',$trading_address) !!}
    {!! Form::text('trading_address',null,['class'=>'form-control','placeholder'=>$write.' '.$trading_address]) !!}
</div>
<div class="form-group">
    {!! Form::label('date',$date) !!}
    {!! Form::input('date','date',date('Y-m-d'),['class'=>'form-control','id'=>'date']) !!}
</div>
<div class="form-group">
    {!! Form::label('representative',$representative) !!}
    {!! Form::select('representative_id',$representatives,null,['class'=>'form-control',]) !!}
</div>
<div class="form-group">
    {!! Form::submit($submitText,['class'=>'btn color']) !!}
</div>


