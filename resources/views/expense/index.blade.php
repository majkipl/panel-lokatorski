@extends('layouts.app')

@section('content')
    <section id="spending">
        <div class="row row-eq-height section-header">
            <div class="col-12 col-sm-6 d-flex align-items-end justify-content-start section-header-headline">
                <h1 class="text-uppercase">{{ __('expenses') }}</h1>
            </div>
            <div
                class="col-12 col-sm-6 d-flex align-items-end justify-content-start justify-content-sm-end section-header-button">
                <h3><a href="{{ route('expense.form') }}" class="cta-button">{{ __('add expense') }}</a></h3>
            </div>

            @include('common.message')

            <div class="col-12 table-spending">
                @foreach($operations as $key_year => $op_year)
                    <div class="row row-year">
                        <div class="col-12 col-xl-1 d-flex align-items-center justify-content-center year-name">
                            <span>{{ $key_year }}</span>
                        </div>
                        <div class="col-12 col-xl-11">
                            @foreach($op_year as $key_month => $op_month)
                                <div class="row row-month">
                                    <div
                                        class="col-12 col-xl-1 d-flex align-items-center justify-content-center month-name">
                                        <span>{{ $key_month }}</span>
                                    </div>
                                    <div class="col-12 col-xl-11 row-content">
                                        @foreach($op_month as $key_operat => $operat)
                                            <div class="row row-item @if($operat['canceled'])cancel @endif">
                                                <div
                                                    class="col-6 col-sm-7 col-md-5 col-lg-3 text-uppercase">{{ $operat['name'] }}</div>
                                                <div
                                                    class="col-4 col-md-3 col-lg-2 text-end">{{ number_format($operat['amount'], 2, ".", ",") }}
                                                    zł
                                                </div>
                                                <div
                                                    class="col-12 col-lg-3 d-none d-lg-block">{{ $operat['created_at'] }}</div>
                                                <div
                                                    class="col-12 col-md-3 d-none d-md-block">{{ $operat['user']->firstname }} {{ $operat['user']->lastname }}</div>
                                                <div class="col-2 col-sm-1 d-flex justify-content-end">
                                                    @if(auth()->user()->account->uuid === $operat['accountUuid'] || auth()->user()->role === \App\Domains\User\Domain\Enums\UserRole::ADMIN->value)
                                                        @if(!$operat['canceled'] && now()->format('Y') == $operat['created_year'] && now()->locale('pl')->isoFormat('MMMM') == $operat['created_month'])
                                                            <a href="{{ route('expense.cancel', ['id' => $operat['event_id']]) }}"
                                                               title="{{ strtoupper(__('cancel')) }}: {{ $operat['name'] }}"
                                                               class="remove-cost">
                                                                <img src="{{ asset('images/svg/x.svg') }}" />
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
