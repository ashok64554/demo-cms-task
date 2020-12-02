@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col mx-auto">
                <div class="text-center mb-6">
                    <img src="{{url('/')}}/{{$appSetting->app_logo}}" class="" alt="{{$appSetting->app_name}}">
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card-group mb-0">
                            <div class="card p-4">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="card-body">
                                        <h1>{{ __('Register') }}</h1>
                                        <p class="text-muted">Sign Up to your account</p>

                                         <div class="input-group mb-3">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            <input id="name" type="name" class="form-control{{ $errors->has('name') ? ' is-invalid state-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="Name" autocomplete="off">

                                            @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid state-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="Email Address" autocomplete="off">

                                            @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="input-group mb-4">
                                            <span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
                                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid state-invalid' : '' }}" name="password" required placeholder="Password" autocomplete="off">

                                            @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                         <div class="input-group mb-4">
                                            <span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
                                            <input id="password" type="password"  class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid state-invalid' : '' }}" name="password_confirmation" required placeholder="Confirm Password" autocomplete="off">

                                            @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                       

                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-gradient-primary btn-block">{{ __('Register') }}</button>
                                            </div>
                                            @if (Route::has('password.request'))
                                            <div class="col-12">
                                               
                                               <a href="{{ route('login') }}" class="btn btn-link box-shadow-0 px-0">{{ __('Login') }}</a>
                                            </div>
                                            @endif

                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card text-white bg-primary py-5 d-md-down-none login-transparent">
                                <div class="card-body text-center justify-content-center ">
                                    <h2>About</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.ed ut perspiciatis unde omnis iste natus error sit voluptatem  </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
