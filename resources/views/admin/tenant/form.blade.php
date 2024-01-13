@extends('layouts.app')

@section('content')
    <section id="payment">
        <div class="row section-header">
            <div class="col-12 section-header-headline">
                <h1 class="text-uppercase">{{ __("add a tenant") }}</h1>
            </div>
            <div class="col-12 form">
                <form id="save" method="POST" action="{{ route('admin.tenant.save') }}">
                    @csrf

                    <x-form.input.email
                        name="email"
                        class="email"
                        label="E-mail"
                        placeholder="mail@example.com"
                        required
                    />

                    <x-form.input.password
                        name="password"
                        class="password"
                        label="{{ __('password') }}"
                        required
                    />

                    <x-form.input.text
                        name="firstname"
                        class="firstname"
                        label="{{ __('firstname') }}"
                        placeholder="Jan"
                        required
                    />

                    <x-form.input.text
                        name="lastname"
                        class="lastname"
                        label="{{ __('lastname') }}"
                        placeholder="Kowalski"
                        required
                    />

                    <x-form.select
                        name="role"
                        class="role"
                        label="{{ __('roles') }}"
                        placeholder="-- USTAW UPRAWNIENIA --"
                        required
                        :items="$roles"
                    />

                    <x-form.select
                        name="status"
                        class="status"
                        label="{{ __('status') }}"
                        placeholder="-- USTAW STATUS --"
                        required
                        :items="$statuses"
                    />

                    <div class="row mb--30">
                        <div class="col-12 d-flex">
                            <input type="submit" name="add" class="cta-button" value="{{ __('add') }}" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
