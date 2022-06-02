    @extends('layouts.auth')
@php
    $logo=asset(Storage::url('uploads/logo/'));
    $company_logo=Utility::getValByName('company_logo');
    $settings = Utility::settings();

@endphp
@push('custom-scripts')

        @if(env('RECAPTCHA_MODULE') == 'yes')
            {!! NoCaptcha::renderJs() !!}
        @endif

@endpush
@section('page-title')
    {{__('Login')}}
@endsection


@section('content')
    <div class="login-contain">
        <div class="login-inner-contain">
            <a class="navbar-brand" href="#">
                <img src="{{$logo.'/'.(isset($company_logo) && !empty($company_logo)?$company_logo:'logo.png')}}" class="navbar-brand-img big-logo" alt="logo">
            </a>
            <div class="login-form" id="form_data">
                <div class="page-title"><h5>{{__('Login')}}</h5></div>
                {{Form::open(array('route'=>'login','method'=>'post','id'=>'loginForm' ))}}
                @csrf
                <div class="form-group">
                    <label for="email" class="form-control-label">{{__('Email')}}</label>
                    <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <div class="invalid-feedback" role="alert">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password" class="form-control-label">{{__('Password')}}</label>
                    <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" required autocomplete="current-password">
                    @error('password')
                    <div class="invalid-feedback" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                {{-------------- ReCaptcha start---------}}
                @if(env('RECAPTCHA_MODULE') == 'yes')
                    <div class="form-group">
                        {!! NoCaptcha::display() !!}
                        @error('g-recaptcha-response')
                        <span class="small text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                @endif

                {{-------------- ReCaptcha end---------}}

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-primary">{{ __('Forgot Your Password?') }}</a>
                @endif

                <button type="submit" class="btn-login" id="login_button">{{__('Login')}}</button>
                @if($settings['enable_signup'] == 'on')
                <div class="or-text">{{__('OR')}}</div>
                <small class="text-muted">{{__("Don't have an account?")}}</small>
                <a href="{{ route('register') }}" class="text-xs text-primary">{{__('Register')}}</a>
                @endif
                {{Form::close()}}
            </div>

            <h5 class="copyright-text">
                {{(Utility::getValByName('footer_text')) ? Utility::getValByName('footer_text') :  __('Copyright ERPGO') }} {{ date('Y') }}
            </h5>
            <div class="all-select">
                <a href="#" class="monthly-btn">
                    <span class="monthly-text py-0">{{__('Change Language')}}</span>
                    <select class="select-box" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" id="language">
                        @foreach(Utility::languages() as $language)
                            <option @if($lang == $language) selected @endif value="{{ route('login',$language) }}">{{Str::upper($language)}}</option>
                        @endforeach
                    </select>
                </a>
            </div>
        </div>
    </div>
@endsection

    <script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#form_data").submit(function (e) {
                $("#login_button").attr("disabled", true);
                return true;
            });
        });
    </script>

