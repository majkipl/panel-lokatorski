@extends('layouts.app')

@section('content')
    <section id="register">
        <div class="row section-header">
            <div class="col-12 section-header-headline">
                <h1 class="text-uppercase">{{ __('register') }}</h1>
            </div>
            <form id="save" method="POST" action="{{ route('register') }}" class="col-12 form">
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

                <x-form.input.password
                    name="password_confirmation"
                    class="password-confirm"
                    label="{{ __('password-confirm') }}"
                    required
                />

                <x-form.input.text
                    name="firstname"
                    class="firstname"
                    label="{{ __('firstname') }}"
                    placeholder=""
                    required
                />

                <x-form.input.text
                    name="lastname"
                    class="lastname"
                    label="{{ __('lastname') }}"
                    placeholder=""
                    required
                />

                <div class="row mb--30">
                    <div class="col-12 d-flex">
                        <input type="submit" name="{{ __('register') }}" class="cta-button" value="{{ __('register') }}" />
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
