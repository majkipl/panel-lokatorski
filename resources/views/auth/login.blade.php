@extends('layouts.app')

@section('content')
    <section id="login">
        <div class="row section-header">
            <div class="col-12 section-header-headline">
                <h1 class="text-uppercase">{{ __('log in') }}</h1>
            </div>
            <form id="save" method="POST" action="{{ route('login') }}" class="col-12 form">
                @csrf

                <x-form.input.email
                    name="email"
                    class="email"
                    label="E-mail"
                    placeholder=""
                    required
                />

                <x-form.input.password
                    name="password"
                    class="password"
                    label="{{ __('password') }}"
                    required
                />

                <x-form.input.checkbox name="remember" class="remember">
                    {{ __('Remember Me') }}
                </x-form.input.checkbox>

                <div class="row mb--30">
                    <div class="col-12 d-flex">
                        <input type="submit" name="login" class="cta-button" value="ZALOGUJ" />

                        @if (Route::has('password.request'))
                            <a class="cta-button-reverse" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
