@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
         <div class="col-md-3">
         </div>
        <div class="col-md-6">
     <div class="hpanel" >
                    <div class="panel-body">
            <div class="card">
                <center><img src="img/Logo.png" width="200px"></center><br>
                <div class="card-header">{{ __('Login') }}</div>
                <hr>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf


                              <div class="form-group">
                                <label class="control-label" for="username">{{ __('E-Mail Address') }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>


                              <div class="form-group">
                                <label class="control-label" for="username">{{ __('Password') }}</label>


                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>

                        <!--<div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>-->


                                <button type="submit" class="btn btn-danger btn-block loginbtn">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <!--<a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>-->
                                @endif

                    </form>
</div></div>
                </div>
            </div>

        </div>
    </div>
</div>
    <script>
        // $(document).ready(function () {
            console.log('done')
            localStorage.removeItem('showModal')
        // });
    </script>
@endsection
