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
                    @elseif(str_contains($error,'phone'))
                        @lang('variables.phone')
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
    {!! Form::label('phone',$phone) !!}
    {!! Form::text('phone',null,['class'=>'form-control','placeholder'=>$write.' '.$phone]) !!}
</div>
<div class="form-group">
    {!! Form::submit($submitText,['class'=>'btn color']) !!}
</div>


