@extends('layouts.app')

@section('content')
    <section id="users">
        <div class="row row-eq-height section-header">
            <div class="col-12 col-sm-6 d-flex align-items-end justify-content-start section-header-headline">
                <h1 class="text-uppercase">{{ __('tenants') }}</h1>
            </div>
            <div
                    class="col-12 col-sm-6 d-flex align-items-end justify-content-start justify-content-sm-end section-header-button">
                <h3><a href="{{ route('admin.tenant.form') }}" class="cta-button">{{ __('add a tenant') }}</a></h3>
            </div>

            @include('common.message')

            <div class="col-12 table-users">
                <div class="row row-head">
                    <div
                            class="col-10 col-sm-5 col-md-3 d-flex align-items-center justify-content-start text-uppercase">{{ __('name') }}</div>
                    <div
                            class="col-12 col-sm-6 col-md-3 d-none d-sm-flex align-items-center justify-content-center text-uppercase">
                        e-mail
                    </div>
                    <div
                            class="col-12 col-sm-2 d-none d-md-flex align-items-center justify-content-center text-uppercase">{{ __('last_login') }}</div>
                    <div
                            class="col-12 col-sm-2 d-none d-md-flex align-items-center justify-content-center text-uppercase">{{ __('status') }}</div>
                    <div
                            class="col-12 col-sm-1 d-none d-md-flex align-items-center justify-content-center text-uppercase">{{ __('role') }}</div>
                    <div class="col-2 col-sm-1 col-md-1 d-flex align-items-center justify-content-end"></div>
                </div>
                @foreach($users as $user)
                    <div class="row">
                        <div
                                class="col-10 col-sm-4 col-md-3 d-flex align-items-center justify-content-start">{{ $user->firstname }} {{ $user->lastname }}</div>
                        <div
                                class="col-12 col-sm-5 col-md-3 d-none d-sm-flex align-items-center justify-content-center">{{ $user->email }}</div>
                        <div
                                class="col-12 col-sm-2 d-none d-md-flex align-items-center justify-content-center">{{ $user->last_login_at }}</div>
                        <div
                                class="col-12 col-sm-2 d-none d-md-flex align-items-center justify-content-center">{{ $user->status }}</div>
                        <div
                                class="col-12 col-sm-1 d-none d-md-flex align-items-center justify-content-center">{{ $user->role }}</div>
                        <div class="col-2 col-sm-1 col-md-1 d-flex align-items-center justify-content-end">
                            @if($user->status === \App\Domains\User\Domain\Enums\UserStatus::ACTIVE->value)
                                <a href="{{ route('admin.tenant.lock', ['user' => $user->id]) }}"
                                   title="{{ strtoupper(__('lock')) }}: {{ $user->firstname }} {{ $user->lastname }}"
                                   class="lock-user">
                                    <img src="{{ asset('images/svg/lock.svg') }}" alt="lock"/>
                                </a>
                            @else
                                <a href="{{ route('admin.tenant.unlock', ['user' => $user->id]) }}"
                                   title="{{ strtoupper(__('unlock')) }}: {{ $user->firstname }} {{ $user->lastname }}"
                                   class="unlock-user">
                                    <img src="{{ asset('images/svg/unlock.svg') }}" alt="unlock"/>
                                </a>
                            @endif

                            <a href="{{ route('billing.user', ['user' => $user->id]) }}"
                               title="{{ strtoupper(__('billing of the tenant')) }} {{ $user->firstname }} {{ $user->lastname }}">
                                <img src="{{ asset('images/svg/billing.svg') }}" alt="billing"/>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
