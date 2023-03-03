<!doctype html>
<html lang="{{config('app.locale') == 'ar' ? 'ar' : 'en'}}" dir="{{config('app.locale') == 'ar' ? 'rtl' : 'ltr'}}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CoreUI CSS -->
    <link rel="stylesheet" href="{{asset('vendors\@coreui\css\coreui.min.css')}}" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap"
          rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }

        .table td, .table th {
            padding: 0.25rem;
        }
    </style>

    <title>{{ config('app.name', 'Laravel') }}</title>
</head>

<body class="c-app flex-row align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        <h1>{{ __('messages.login') }}</h1>
                        <p class="text-muted">{{__('messages.Sign In to your account')}}</p>


                        <form method="POST" action="{{ route('login') }}">
                            @csrf


                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <svg class="c-icon">
                                            <use
                                                xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-user')}}"></use>
                                        </svg>
                                    </span>
                                </div>
                                <input id="username" type="text"
                                       class="form-control @error('username') is-invalid @enderror"
                                       name="username" value="{{ old('username') }}" required
                                       autocomplete="username" autofocus placeholder="{{__('messages.username')}}">
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <svg class="c-icon">
                                            <use
                                                xlink:href="{{asset('vendors/@coreui/icons/svg/free.svg#cil-lock-locked')}}"></use>
                                        </svg>
                                    </span>
                                </div>
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password" required autocomplete="current-password" placeholder="{{__('messages.password')}}">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('messages.remember_me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-primary px-4" type="submit">{{ __('messages.login') }}</button>
                                </div>
                            </div>


                        </form>


                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="{{asset('vendors/@coreui/coreui/js/coreui.bundle.min.js')}}"></script>
<!--[if IE]><!-->
<script src="{{asset('vendors/@coreui/icons/js/svgxuse.min.js')}}"></script>
<!--<![endif]-->

</body>

</html>
