@extends('app')
@section('title')
    @lang('variables.hello')
@stop
@section('content')
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        <h1>

            @lang('variables.new_user')
        </h1>
        <hr>
        <div>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>@lang('variables.there_is_an_error')</strong>
                @lang('variables.make_it_right')
                @lang('variables.and')
                @lang('variables.try_again')



                @foreach ($errors->all() as $key=>$error)

                    <div>
                        @if(str_contains($error,'email'))
                            @lang('variables.user_name')
                        @elseif(str_contains($error,'password'))
                            @lang('variables.password')
                        @elseif(str_contains($error,'password confirmation'))
                            @lang('variables.confirm') @lang('variables.password')
                        @endif
                        @if(str_contains($error,'required'))
                            @lang('variables.required')
                        @elseif(str_contains($error,'match'))
                            @lang('variables.do_not') @lang('variables.match')
                        @elseif(str_contains($error,'at least 6'))
                            @lang('variables.at_least_6')
                        @elseif(str_contains($error,'taken'))
                                @lang('variables.taken')
                        @endif
{{--                        {{$error}}--}}
                    </div>

                @endforeach
            </div>

        @endif
        </div>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label for="email">@lang('variables.user_name')</label>

                <input type="text" class="form-control" name="email" value="{{ old('email') }}">

            </div>

            <div class="form-group">
                <label for="password">@lang('variables.password')</label>

                <input type="password" class="form-control" name="password" value="">

            </div>

            <div class="form-group">
                <label for="password_confirmation">@lang('variables.confirm') @lang('variables.password')</label>

                <input type="password" class="form-control" name="password_confirmation">

            </div>
            <div class="form-group">
                <label for="type">@lang('variables.type')</label>

                <select name="type" class="form-control">
                    <option value="admin">@lang('variables.admin')</option>
                    <option value="user" selected>@lang('variables.user')</option>
                </select>
            </div>

            <div class="form-group">

                <button type="submit" class="btn color">
                    @lang('variables.add')
                </button>

            </div>
        </form>


    </div>
@stop