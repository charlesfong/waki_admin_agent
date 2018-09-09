@extends('layouts.app')

@section('content')
<div class="container">
    <div class="contact-clean" style="position:fixed;top:50%;left:50%;transform:translate(-50%, -50%);width:360px;">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group" style="margin-bottom:40px;"><img src="{{ asset('img/waki.png') }}" style="width:100%;"></div>
            <h4 class="text-center">WAKi DATA</h4>
            <div class="form-group">
                <input id="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" type="text" name="username" placeholder="Username" value="{{ old('username') }}" required autofocus style='text-transform:uppercase;'>

                @if ($errors->has('username'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <input id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password" placeholder="PASSWORD" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group"><button class="btn btn-primary btn-block" type="submit">LOGIN</button></div>
        </form>
    </div>
</div>
@endsection
