@extends('layouts.app')

@section('content')
    <section id="billing">
        <div class="row row-eq-height section-header">
            <div class="col-12 d-flex align-items-end justify-content-start section-header-headline">
                <h1>{{ strtoupper(__('billing')) }} - {{ $user->firstname }} {{ $user->lastname }}</h1>
            </div>
            <div class="col-12">
                <p class="w-100">Jeśli wyjdzie <strong>NIEDOPŁATA</strong> to należność proszę przelać na rachunek:
                    <strong>14 1140 2004 0000 3102 6763 1792</strong> lub poprzez <a href="https://revolut.me/rafa83ciq"
                                                                                     title="Revolut" target="_blank">https://revolut.me/rafa83ciq</a>
                </p>
                <p class="w-100">Jeśli wyjdzie <strong>NADPŁATA</strong> to automatycznie przechodzi na następny
                    miesiąc. Ewentualnie na życzenie robię zwrot na wskazany rachunek lub RevolutTag.</p>
            </div>
            <div class="col-12 table-billing">
                @foreach($billing->years as $key_year => $b_year)
                    <div class="row row-year">
                        <div class="col-12 col-xl-1 d-flex align-items-center justify-content-center">
                            <span class="year-name">{{ $key_year }}</span>
                        </div>
                        <div class="col-12 col-xl-11">
                            @foreach($b_year->months as $key_month => $b_month)
                                <div class="row row-month">
                                    <div
                                        class="col-12 col-xl-1 d-flex align-items-center justify-content-center">
                                        <span class="month-name">{{ $key_month }}</span>
                                    </div>
                                    <div class="col-12 col-xl-11 row-content">
                                        <div class="row row-item">
                                            <div class="col-8 col-sm-9 col-md-10 text-start text-sm-end">
                                                <p class="first-letter-uppercase">{{ __('beginning balance') }} :
                                                    <span class="text-uppercase">@if($b_month->getArrears() > 0)
                                                            ({{ __('overpayment') }})
                                                        @else
                                                        ({{ __('underpayment') }})
                                                        @endif</span>
                                                </p>
                                            </div>
                                            <div
                                                class="col-4 col-sm-3 col-md-2 d-flex align-items-end justify-content-end">
                                                <p>{{ number_format($b_month->getArrears(), 2, ".", ",") }} zł</p>
                                            </div>
                                            {{--                                            <div class="col-8 col-sm-9 col-md-10 text-start text-sm-end">--}}
                                            {{--                                                <p>Wydatki ogółem :</p>--}}
                                            {{--                                            </div>--}}
                                            {{--                                            <div--}}
                                            {{--                                                class="col-4 col-sm-3 col-md-2 d-flex align-items-end justify-content-end">--}}
                                            {{--                                                <p>??? zł</p>--}}
                                            {{--                                            </div>--}}
                                            <div class="col-8 col-sm-9 col-md-10 text-start text-sm-end flu">
                                                <p class="first-letter-uppercase">{{ __('your expenses') }} :</p>
                                            </div>
                                            <div
                                                class="col-4 col-sm-3 col-md-2 d-flex align-items-end justify-content-end">
                                                <p>{{ $b_month->getExpense() }} zł</p></div>
                                            <div class="col-8 col-sm-9 col-md-10 text-start text-sm-end">
                                                <p class="first-letter-uppercase">{{ __('expenditures per head') }}
                                                    :</p>
                                            </div>
                                            <div
                                                class="col-4 col-sm-3 col-md-2 d-flex align-items-end justify-content-end">
                                                <p>{{ $b_month->getExpensePerCapita() }} zł</p></div>
                                            {{--                                            <div class="col-8 col-sm-9 col-md-10 text-start text-sm-end">--}}
                                            {{--                                                <p>Twój udział w wydatkach--}}
                                            {{--                                                    ({{ $b_month->getBalance() < 0 ? 'NIEDOPŁATA' : 'NADPŁATA' }}--}}
                                            {{--                                                    ) :</p>--}}
                                            {{--                                            </div>--}}
                                            {{--                                            <div--}}
                                            {{--                                                class="col-4 col-sm-3 col-md-2 d-flex align-items-end justify-content-end">--}}
                                            {{--                                                <p>{{ $b_month->getBalance() }} zł</p>--}}
                                            {{--                                            </div>--}}
                                            <div class="col-8 col-sm-9 col-md-10 text-start text-sm-end">
                                                <p class="first-letter-uppercase">
                                                    @if($b_month->getPayment() >= 0)
                                                        {{ __('registered payment') }}:
                                                    @else
                                                        {{ __('registered payout') }}:
                                                    @endif
                                                </p>
                                            </div>
                                            <div
                                                class="col-4 col-sm-3 col-md-2 d-flex align-items-end justify-content-end">
                                                <p>{{ $b_month->getPayment() }} zł</p>
                                            </div>
                                            <div class="col-8 col-sm-9 col-md-10 text-start text-sm-end">
                                                <p class="first-letter-uppercase">{{ __('your current balance') }}
                                                    (<span class="text-uppercase">{{ $b_month->getCumulativeBalance() < 0 ? __('underpayment') : __('overpayment') }}</span>):</p>
                                            </div>
                                            <div
                                                class="col-4 col-sm-3 col-md-2 d-flex align-items-end justify-content-end">
                                                <p>{{ number_format($b_month->getCumulativeBalance(), 2, ".", ",") }}
                                                    zł</p>
                                            </div>
                                        </div>
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
