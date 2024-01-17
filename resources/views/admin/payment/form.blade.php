@extends('layouts.app')

@section('content')
    <section id="payment">
        <div class="row section-header">
            <div class="col-12 section-header-headline">
                <h1 class="text-uppercase">{{ __('add deposit/withdrawal') }}</h1>
            </div>
            <div class="col-12 form">
                <form id="save" method="POST" action="{{ route('admin.payment.save') }}">
                    @csrf

                    <x-form.select
                        name="user_id"
                        class="user_id"
                        label="{{ __('person') }}"
                        placeholder="-- WYBIERZ LOKATORA --"
                        required
                        :items="$users"
                    />

                    <x-form.input.number
                        name="amount"
                        class="amount"
                        label="{{ __('amount') }}"
                        placeholder="0.00"
                        required
                        suffix="zł"
                        step="0.01"
                    />

                    <div class="row mb-4">
                        <div class="col-12 d-flex">
                            <input type="submit" name="add" class="cta-button" value="{{ __('add') }}" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
