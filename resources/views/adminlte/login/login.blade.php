@extends(env('ADMIN_TEMPLATE').'.layout.base')

@section('title', __('general.login'))
@section('body-class', 'login-page')

@section('header')
@stop
@section('footer')
@stop

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <b>{{ env('WEBSITE_NAME') }}</b>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">@lang('general.sign_in_header')</p>

            {{ Form::open(['route' => 'admin.login.post', 'id'=>'form', 'novalidate'=>'novalidate'])  }}
                <div class="form-group has-feedback {{ $errors->has('username') ? 'has-error' : '' }}">
                    {{ Form::text('username', old('username'), ['id'=>'username', 'class'=>'form-control', 'placeholder'=>__('general.username'), 'required'=>'required']) }}
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('username'))
                        <span class="help-block">{{ $errors->first('username') }}</span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                    {{ Form::password('password', ['id'=>'password', 'class'=>'form-control', 'placeholder'=>__('general.password'), 'required'=>'required']) }}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                @if ($errors->has('error_login'))
                    <div class="form-group has-feedback has-error">
                        <span class="help-block">{{ $errors->first('error_login') }}</span>
                    </div>
                @endif
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">@lang('general.sign_in')</button>
                    </div>
                    <!-- /.col -->
                </div>
            {{ Form::close() }}

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
@stop