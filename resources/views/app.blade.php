</<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="{{ URL::asset('/fav.png')}}">

    <title>
        @yield('title')
    </title>
    <link rel="stylesheet" media="all" type="text/css" href="{{ URL::asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" media="all" type="text/css" href="{{ URL::asset('css/bootstrap-theme.min.css')}}">
    <link rel="stylesheet" media="all" type="text/css" href="{{ URL::asset('css/ar.css')}}">
    {{--<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />--}}

    @yield('css')
</head>
<body>
<nav class="nav-color">
    <div class="container-fluid title3">
        <div class="navbar-header navbar-right">
            <a class="navbar-brand  dash_link" href="/">
                <img alt="@lang('variables.system') @lang('variables.clients') " src="">
            </a>

        </div>

        <div class="navbar-header navbar-nav">

            <a href="/auth/logout" class="navbar-brand dash_link">
                @lang('variables.logout')
            </a>

        </div>

    </div>
</nav>

{{--<div class="row">--}}
<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
    <div class='container-fluid'>
        @yield('content')
    </div>
</div>
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 Dashboard">
    {{--******************Client Element**************--}}
    <div class="panel-default">
        <a class="collapsed" role="button"
           data-toggle="collapse" data-parent="#accordion"
           href="#collapseClient" aria-expanded="false"
           aria-controls="collapseClient">
            <div class="color title3 panel_title" role="tab" id="headingClient">
                @lang('variables.clients')
            </div>
        </a>

        <div id="collapseClient" class="panel-collapse collapse color" role="tabpanel" aria-labelledby="headingClient">
            <div class="panel-body title4">
                <a role="button" href="/client" class="dash_link">
                    @lang('variables.search')
                    <span class="glyphicon glyphicon-search"></span>
                </a>
                <br>
                <a role="button"  href="/client/create" class="dash_link">

                    @lang('variables.add') @lang('variables.client')
                    <span class="glyphicon glyphicon-plus"></span>
                </a>
            </div>
            </div>
        </div>

    {{--**********************************************--}}
    <hr>
    {{--******************Representative Element******--}}
    @if(Auth::user()->type !='representative')
    <div class="panel-default">
        <a class="collapsed" role="button"
           data-toggle="collapse" data-parent="#accordion"
           href="#collapseRepresentative" aria-expanded="false"
           aria-controls="collapseRepresentative">
            <div class="color title3 panel_title" role="tab" id="headingRepresentative">
                @lang('variables.representatives')
            </div>
        </a>

        <div id="collapseRepresentative" class="panel-collapse collapse color" role="tabpanel" aria-labelledby="headingRepresentative">
            <div class="panel-body title4">
                <a role="button" href="/representative" class="dash_link">
                    @lang('variables.search')
                    <span class="glyphicon glyphicon-search" ></span>
                </a>
                <br>
                <a role="button"  href="/auth/register" class="dash_link">

                    @lang('variables.add') @lang('variables.representative1')
                    <span class="glyphicon glyphicon-plus"></span>
                </a>
            </div>
        </div>
    </div>
    <hr>
    @endif
    {{--**********************************************--}}

    {{--******************item Element**************--}}
    @if(Auth::user()->type!='user')
    <div class="panel-default">
        <a class="collapsed" role="button"
           data-toggle="collapse" data-parent="#accordion"
           href="#collapseitem" aria-expanded="false"
           aria-controls="collapseitem">
            <div class="color title3 panel_title" role="tab" id="headingitem">
                @lang('variables.items')
            </div>
        </a>

        <div id="collapseitem" class="panel-collapse collapse color" role="tabpanel" aria-labelledby="headingitem">
            <div class="panel-body title4">
                <a role="button" href="/item" class="dash_link">
                    @lang('variables.search')
                    <span class="glyphicon glyphicon-search"></span>
                </a>
                <br>
                @if(Auth::user()->type=='admin')
                    <a role="button"  href="/item/create" class="dash_link">

                        @lang('variables.add') @lang('variables.item')
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                @endif
            </div>
        </div>
    </div>
    <hr>
    @endif
    {{--**********************************************--}}

    {{--******************invoice Element**************--}}
    @if(Auth::user()->type!='user')
    <div class="panel-default">
        <a class="collapsed" role="button"
           data-toggle="collapse" data-parent="#accordion"
           href="#collapseinvoice" aria-expanded="false"
           aria-controls="collapseinvoice">
            <div class="color title3 panel_title" role="tab" id="headinginvoice">
                @lang('variables.invoices')
            </div>
        </a>

        <div id="collapseinvoice" class="panel-collapse collapse color" role="tabpanel" aria-labelledby="headinginvoice">
            <div class="panel-body title4">
                <a role="button" href="/invoice" class="dash_link">
                    @lang('variables.search')
                    <span class="glyphicon glyphicon-search"></span>
                </a>
                <br>
                <a role="button"  href="/invoice/create" class="dash_link">

                    @lang('variables.add') @lang('variables.invoice')
                    <span class="glyphicon glyphicon-plus"></span>
                </a>
            </div>
        </div>
    </div>
    <hr>
    @endif
    {{--**********************************************--}}

    @if(Auth::user()->type=='admin')
        {{--******************user Element**************--}}
        <div class="panel-default">
            <a class="collapsed" role="button"
               data-toggle="collapse" data-parent="#accordion"
               href="#collapseUser" aria-expanded="false"
               aria-controls="collapseUser">
                <div class="color title3 panel_title" role="tab" id="headingUser">
                    @lang('variables.users')
                </div>
            </a>

            <div id="collapseUser" class="panel-collapse collapse color" role="tabpanel" aria-labelledby="headingUser">
                <div class="panel-body title4">
                    {{--<a role="button" href="/client">--}}
                        {{--@lang('variables.search')--}}
                        {{--<span class="glyphicon glyphicon-search"></span>--}}
                    {{--</a>--}}
                    <br>
                    <a role="button"  href="/auth/register" class="dash_link">

                        @lang('variables.add') @lang('variables.user')
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                </div>
            </div>
        </div>

        {{--**********************************************--}}
        <hr>
    @endif
</div>
{{--</div>--}}

<script src="{{ URL::asset('js/jquery-2.1.3.js')}}"></script>
{{--<script src="{{ URL::asset('js/select2.min.js')}}"></script>--}}
<script src="{{URL::asset('js/bootstrap.min.js')}}"></script>
@yield('js')
</body>
</html>