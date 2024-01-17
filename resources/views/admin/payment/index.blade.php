@extends('layouts.app')

@section('content')
    <section id="payment">
        <div class="row row-eq-height section-header">
            <div class="col-12 col-sm-6 d-flex align-items-end justify-content-start section-header-headline">
                <h1 class="text-uppercase">{{ __('payments') }} / {{ __('payouts') }}</h1>
            </div>
            <div class="col-12 col-sm-6 d-flex align-items-end justify-content-start justify-content-sm-end section-header-button">
                <h3><a href="{{ route('admin.payment.form') }}" class="cta-button">{{ __('add') }}</a></h3>
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
                                    <div class="col-12 col-xl-1 d-flex align-items-center justify-content-center month-name">
                                        <span>{{ $key_month }}</span>
                                    </div>
                                    <div class="col-12 col-xl-11 row-content">
                                        @foreach($op_month as $key_operat => $operat)
                                            <div class="row row-item">
                                                <div class="col-6 col-sm-7 col-md-5 col-lg-3">@if($operat['type'] === 'MoneyAdded') WPŁATA @else WYPŁATA @endif</div>
                                                <div class="col-4 col-md-3 col-lg-2 text-right">{{ number_format($operat['amount'], 2, '.', ',') }} zł</div>
                                                <div class="col-12 col-lg-3 d-none d-lg-block">{{ $operat['created_at'] }}</div>
                                                <div class="col-12 col-md-3 d-none d-md-block">{{ $operat['user']->firstname }} {{ $operat['user']->lastname }}</div>
                                                <div class="col-2 col-sm-1 d-flex justify-content-end">
{{--                                                    @if(date_format(now(), "%Y") == $operat['created_year'] && date_format(now(), "%m") == $operat['created_month'])--}}
{{--                                                        <a href="/usun-wplate/id,{{ $operat['id'] }}" title="USUŃ: {{ $operat['name'] }}" class="remove-cost">--}}
{{--                                                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 348.333 348.334" style="enable-background:new 0 0 348.333 348.334;" xml:space="preserve"><g><path d="M336.559,68.611L231.016,174.165l105.543,105.549c15.699,15.705,15.699,41.145,0,56.85 c-7.844,7.844-18.128,11.769-28.407,11.769c-10.296,0-20.581-3.919-28.419-11.769L174.167,231.003L68.609,336.563 c-7.843,7.844-18.128,11.769-28.416,11.769c-10.285,0-20.563-3.919-28.413-11.769c-15.699-15.698-15.699-41.139,0-56.85 l105.54-105.549L11.774,68.611c-15.699-15.699-15.699-41.145,0-56.844c15.696-15.687,41.127-15.687,56.829,0l105.563,105.554 L279.721,11.767c15.705-15.687,41.139-15.687,56.832,0C352.258,27.466,352.258,52.912,336.559,68.611z"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>--}}
{{--                                                        </a>--}}
{{--                                                    @endif--}}
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
