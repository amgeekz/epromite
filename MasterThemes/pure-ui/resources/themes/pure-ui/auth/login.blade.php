{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.auth')

@section('title')
    Login
@endsection

@section('content')

	<div class="limiter">
		<div class="container-login100">
				<div class="row">
					<div class="col-sm-offset-11 col-xs-offset-9 col-sm-14 col-xs-18 mx-auto">
						@if (count($errors) > 0)
							<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close" id="authenError" data-toggle="tooltip"><span aria-hidden="true">&times;</span></button>
								@lang('auth.auth_error')<br><br>
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
						@foreach (Alert::getMessages() as $type => $messages)
							@foreach ($messages as $message)
								<div class="callout callout-{{ $type }} alert-dismissable" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									{!! $message !!}
								</div>
							@endforeach
						@endforeach
					</div>
				</div>
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<a href="{{ route('auth.login') }}" style="cursor: default;"><img src="/themes/pure-ui/logo.png" alt="IMG"></a>
				</div>
		
				
				<form class="login100-form validate-form" id="loginForm" action="{{ route('auth.login') }}" method="post">
					<span class="login100-form-title">Login to your account</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input type="text" name="user" class="form-control input-lg input100" value="{{ old('user') }}" required placeholder="@lang('strings.user_identifier')" autofocus>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input type="password" name="password" class="form-control input-lg input100" required placeholder="@lang('strings.password')">

						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						{!! csrf_field() !!}
						<button type="submit" class="login100-form-btn btn btn-primary btn-block g-recaptcha pterodactyl-login-button--main" @if(config('recaptcha.enabled')) data-sitekey="{{ config('recaptcha.website_key') }}" data-callback='onSubmit' @endif>@lang('auth.sign_in')</button>
					</div>

					<div class="text-center p-t-12">
						<a href="{{ route('auth.password') }}">I forgot my password</a>
					</div>

					<div class="text-center p-t-90">
						<a class="txt2" href="#">
							<p class="small login-copyright text-center">Copyright &copy; 2015 - {{ date('Y') }} <a href="https://pterodactyl.io/">Pterodactyl Software</a>. Theme by HookDonn_.</p>
						</a>
					</div>
					<div class="text-center p-t-5">
						<a class="txt2" href="#">
            				<strong><i class="fa fa-fw {{ $appIsGit ? 'fa-git-square' : 'fa-code-fork' }}"></i></strong> {{ $appVersion }}
							<strong><i class="fa fa-fw fa-clock-o"></i></strong> {{ round(microtime(true) - LARAVEL_START, 3) }}s
							<strong><i class="fa fa-fw fa-gear"></i></strong> {{ config('app.theme_version', 'NS') }}
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
    @parent
    @if(config('recaptcha.enabled'))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
        function onSubmit(token) {
            document.getElementById("loginForm").submit();
        }
        </script>
     @endif
@endsection