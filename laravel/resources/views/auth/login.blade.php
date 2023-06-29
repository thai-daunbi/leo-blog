@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                    <!-- <a href="#" onClick="loginWithFacebook()">Facebook으로 로그인</a> -->
                    <!-- <button type="button" onclick="loginWithFacebook()">Facebook으로 로그인</button> -->
                    
                    <a href="javascript:void(0)" id="btn-fblogin" onclick="loginWithFacebook()">
                        <i class="fa fa-facebook-square" aria-hidden="true"></i> Login with Facebook
                    </a>
                    <!-- <div class="flex items-center justify-end mt-4">
                        <a class="ml-1 btn btn-primary" href="{{ url('login/facebook') }}" style="margin-top: 0px !important;background: #4c6ef5;color: #ffffff;padding: 5px;border-radius:7px;" id="btn-fblogin">
                            <i class="fa fa-facebook-square" aria-hidden="true"></i> Login with Facebook
                        </a>
                    </div> -->
                    <!-- <fb:login-button
                        scope="public_profile,email"
                        onlogin="checkLoginState();">
                    </fb:login-button> -->

                    <!-- linkedin -->
                    <!-- <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <a href="{{ route('auth.linkedin') }}" class="btn btn-secondary">Login with LinkedIn</a>
                        </div>
                    </div> -->

                    <div class="block mt-4">
                    <div class="col-12 text-center">
                        @foreach(config('app_frontend.supported_social_login') as $social)
                        <a href="{{ route('social.login',$social ) }}" class="btn btn-primary">Login with {{ $social }}</a>

                        @endforeach

                    </div>
                </div>

                    <div id="fb-root"></div>
                </div>
            </div>
        </div>
        <!-- facebook login -->
        <!-- <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
        <script>
            function statusChangeCallback(response) {
                if (response.status === 'connected') {
                    // 로그인 상태가 연결된 경우 실행되는 코드
                } else {
                    // 로그인 상태가 연결되지 않은 경우 실행되는 코드
                }
            }

            function checkLoginState() {
                FB.getLoginStatus(function(response) {
                    statusChangeCallback(response);
                });
            }

            function loginWithFacebook() {
                FB.login(function(response) {
                    if (response.authResponse) {
                        // 로그인 성공시 리디렉션: /login/facebook
                        window.location.href = "/login/facebook";
                    } else {
                        console.log("Facebook 로그인 실패");
                    }
                });
            }

            window.fbAsyncInit = function() {
                FB.init({
                    appId      : '1302467250345117',
                    autoLogAppEvents : true,
                    xfbml            : true,
                    version          : 'v17.0',
                    status           : true, // 자동로그인 여부
                    cookie           : true, // 쿠키 사용 여부
                    channelUrl       : 'https://localhost:8090/login/facebook/callback' //channel.html 설정
                });
                FB.AppEvents.logPageView();
                (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) {return;}
                    js = d.createElement(s); js.id = id;
                    js.src = "https://connect.facebook.net/en_US/sdk.js";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));

            };
            
        </script> -->
    </div>
</div>

@endsection
