<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="../fav.png">


    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css')}}">
    {{--<link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">--}}
    {{--<link rel="stylesheet" type="text/css" href="../css/ar.css">--}}
    <title> @lang('variables.system') @lang('variables.clients')</title>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css//login.css')}}">
</head>
<body>
<div class="container">
    <div class="col-lg-3">

    </div>
    <div class="col-lg-6">
        <h1 class="title">
            @lang('variables.system') @lang('variables.clients')
        </h1>
        <h2 class="title2">
            @lang('variables.login')
        </h2>

        <form  class="form-horizontal" role="form"  method="POST" action="{{ URL::action('Auth\AuthController@postLogin') }}">
            {{--{!! csrf_field() !!}--}}
{{--            {{csrf_token()}}--}}
            {{--{!! csrf_field() !!}--}}

            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <div class="form-group">
                <label class="label">@lang('variables.user_name') </label>
                <br>
                <input type="text" name="email" class="form-control" value="">
            </div>

            <div class="form-group">
                <label class="label"> @lang('variables.password')</label>
                <br>
                <input type="password" name="password" class="form-control" id="password">
            </div>

            <div class="form-group">

               <label class="label">
                   @lang('variables.remember_me')  @lang('variables.login')
               </label>
                   <input type="checkbox"  name="remember">
            </div>

            <div>
                <button type="submit" class="btn btn-default color"> @lang('variables.login')</button>
            </div>
        </form>
        {{--<div class="reg">--}}
            {{--<a href="/auth/register" class="link">--}}
                {{--<b>@lang('variables.add') @lang('variables.new_user')</b>--}}
            {{--</a>--}}
        {{--</div>--}}
        <div class="error_container">
        @if (count($errors) > 0)
            <div>
                <h4 class="error">@lang('variables.login_error')</h4>
            </div>
        @endif
        </div>
    </div>
    <div class="col-lg-3">

    </div>
</div>
</body>
</html>
