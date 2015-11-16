<div>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>@lang('variables.there_is_an_error')</strong>
            @lang('variables.make_it_right')
            @lang('variables.and')
            @lang('variables.try_again')
            @foreach ($errors->all() as $key=>$error)
                <div>
                    @if(str_contains($error,'name'))
                        @lang('variables.name')
                    @elseif(str_contains($error,'price'))
                        @lang('variables.price')
                    @endif
                    @if(str_contains($error,'required'))
                        @lang('variables.required')
                    @elseif(str_contains($error,'at least'))
                        @lang('variables.at_least_12')
                    @elseif(str_contains($error,'taken'))
                        @lang('variables.taken')
                    @endif
                        {{--{{$error}}--}}
                </div>
            @endforeach
        </div>

    @endif
</div>
<div class="form-group">
    {!! Form::label('name',$name) !!}
    {!! Form::text('name',null,['class'=>'form-control','placeholder'=>$write.' '.$name ]) !!}
</div>
<div class="form-group">
    {!! Form::label('code',$code) !!}
    {!! Form::text('code',null,['class'=>'form-control','placeholder'=>$write.' '.$code  ,'maxlength'=>'16']) !!}
</div>
<div class="form-group">
    {!! Form::label('price','A 31 '.$price) !!}
    {!! Form::input('number','price_31_a',null,['class'=>'form-control','id'=>'price','min'=>'0','step'=>"0.001"]) !!}
</div>
<div class="form-group">
    {!! Form::label('price','B 32 '.$price) !!}
    {!! Form::input('number','price_32_b',null,['class'=>'form-control','id'=>'price','min'=>'0','step'=>"0.001"]) !!}
</div>
<div class="form-group">
    {!! Form::label('price','1050 '.$price) !!}
    {!! Form::input('number','price_1050',null,['class'=>'form-control','id'=>'price','min'=>'0','step'=>"0.001"]) !!}
</div>
<div class="form-group">
    {!! Form::label('price','1250 '.$price) !!}
    {!! Form::input('number','price_1250',null,['class'=>'form-control','id'=>'price','min'=>'0','step'=>"0.001"]) !!}
</div>
<div class="form-group">
    {!! Form::label('price','1034 '.$price) !!}
    {!! Form::input('number','price_1034',null,['class'=>'form-control','id'=>'price','min'=>'0','step'=>"0.001"]) !!}
</div>
<div class="form-group">
{!! Form::label('picture',$picture) !!}
{!! Form::file('picture', ['class'=>'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::submit($submitText,['class'=>'btn color']) !!}
</div>


