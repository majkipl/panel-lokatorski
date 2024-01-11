@extends('layouts.app')

@section('content')
    <section id="reset">
        <div class="row section-header">
            <div class="col-12 section-header-headline">
                <h1 class="text-uppercase">{{ __('reset password') }}</h1>
            </div>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form id="save" method="POST" action="{{ route('password.email') }}" class="col-12 form">
                @csrf

                <x-form.input.email
                    name="email"
                    class="email"
                    label="E-mail"
                    placeholder=""
                    required
                />

                <div class="row">
                    <div class="col-12 d-flex">
                        <button type="submit" class="cta-button">
                            {{ __('send password reset link') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
