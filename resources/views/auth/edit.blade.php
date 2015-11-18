@extends('app')
@section('title')
    @lang('variables.edit') @lang('variables.info') {{$user->name}}
@stop
@section('content')
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        <h1>
            @lang('variables.edit') @lang('variables.info') {{$user->name}}
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
                            @elseif(str_contains($error,'name'))
                                @lang('variables.name')
                            @elseif(str_contains($error,'phone'))
                                @lang('variables.phone')
                            @elseif(str_contains($error,'password confirmation'))
                                @lang('variables.confirm') @lang('variables.password')
                            @endif
                            @if(str_contains($error,'required'))
                                @lang('variables.required')
                            @elseif(str_contains($error,'match'))
                                @lang('variables.do_not') @lang('variables.match')
                            @elseif(str_contains($error,'at least 6'))
                                @lang('variables.at_least_6')
                            @elseif(str_contains($error,'at least'))
                                @lang('variables.at_least_12')
                            @elseif(str_contains($error,'taken'))
                                @lang('variables.taken')
                            @endif
                            {{--                        {{$error}}--}}
                        </div>

                    @endforeach
                </div>
            @endif
        </div>
        <form class="form-horizontal" role="form" method="POST" action="{{ URL::action('HomeController@user_all') }}/{{$user->id}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div id="representative_data" >
                <div class="form-group">
                    <label for="type">@lang('variables.name')</label>
                    <input type="text" class="form-control" name="name" value="{{$user->name}}" placeholder="@lang('variables.write') @lang('variables.name')">
                </div>
            </div>
            <div class="form-group">
                <label for="email">@lang('variables.user_name')</label>

                <input type="text" class="form-control" name="email" value="{{ $user->email }}">

            </div>

            <div class="form-group">

                @if(Auth::user()->type=='admin')
                    <label for="type">@lang('variables.type')</label>
                    <select name="type" class="form-control" id="type">
                        <option value="admin" {{$user->type=='admin'?'selected':''}}>@lang('variables.admin')</option>
                        <option value="user"  {{$user->type=='user'?'selected':''}}>@lang('variables.customer_support')</option>
                        <option value="representative" {{$user->type=='representative'?'selected':''}}>@lang('variables.representative1')</option>
                    </select>
                @else
                    <input type="hidden" name="type" id="type" value="representative">
                @endif
            </div>

            <div id="hidden"> </div>
            <div class="form-group" >
                <button type="button" class="btn btn-warning"
                                             data-toggle="modal" data-target="#PasswordFormModel">
                    @lang('variables.change_password')
                </button>
                <br> <br>
                <button type="submit" class="btn color">
                    @lang('variables.edit')
                </button>
            </div>

        </form>
        <!-- Modal -->
        <div class="modal fade" id="PasswordFormModel"
             role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">
                            @lang('variables.change_password')
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div id="step1">
                            <div class="form-group">
                                <label for="password">@lang('variables.password')</label>
                                <input type="password" class="form-control"  value="" id="admin_password">

                            </div>
                            <button type="button" id="admin_confirm_password">
                                @lang('variables.confirm')
                            </button>
                        </div>
                        <div id="step2">

                            <div class="form-group">
                                <label for="password">@lang('variables.password')</label>
                                <input type="password" class="form-control" id="password">
                                <span class="alert-danger" id="password_error"></span>

                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">@lang('variables.confirm') @lang('variables.password')</label>
                                <input type="password" class="form-control" id="password_confirmation">
                                <span class="alert-danger" id="password_confirmation_error"></span>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">
                            @lang('variables.cancel')
                        </button>
                        <button type="button" class="btn color" id="password_change">
                            @lang('variables.edit')
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop
@section('js')
   <script> //hidden
       $(document).ready(function(){
           $('#step1').hide();
//           var flag=false;
           function validate_pass()
           {
               var pass=$('#password').val();
               var pass_confirm=$('#password_confirmation').val();
                if(pass!=''&pass.length>6&&pass_confirm!=''&&pass_confirm.length>6&&(pass==pass_confirm))
                {
                    return true;
                }
                else
                {
                    return false;
                }
           }
           $('#password_change').click(function(){
               if(validate_pass())
               {
                    var input='<input type="hidden" name="password" value="'+$('#password').val()+'">';
                    $('#hidden').html(input);
                   $('#PasswordFormModel').modal('hide');
               }
               else{
                   alert('صحح الاخطاء و اعد المحاولة');
               }
           });
           $('#password').keyup(function(){
               var pass=$('#password').val();
               var message='';
               if(pass=='')
               {
                     message="@lang('variables.password')  @lang('variables.required')";
               }
                if(pass.length<6)
               {
                    message+="<br> @lang('variables.password')  @lang('variables.at_least_6')"
               }

               $('#password_error').html(message);
           });
           $('#password_confirmation').keyup(function(){
               var pass=$('#password').val();
               var pass_confirm=$('#password_confirmation').val();
               var message='';
               if(pass_confirm=='')
               {
                   message="@lang('variables.confirm') @lang('variables.password')  @lang('variables.required')";
               }
                if(pass_confirm.length<6)
               {
                   message+="<br>@lang('variables.confirm') @lang('variables.password') @lang('variables.at_least_6')"
               }
               if(pass_confirm!=pass)
               {
                   message+='<br> @lang('variables.confirm') @lang('variables.password')  @lang('variables.do_not') @lang('variables.match')';
               }
               $('#password_confirmation_error').html(message);
           });
           {{--$('#admin_confirm_password').click(function(){--}}

               {{--var from_serever="{{Auth::user()->password}}";--}}

           {{--});--}}
       });

   </script>
@stop