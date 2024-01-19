@extends('layouts.app')

@section('content')
    <section id="spending">
        <div class="row section-header">
            <div class="col-12 section-header-headline">
                <h1 class="text-uppercase">{{ __('add expense') }}</h1>
            </div>
            <div class="col-12 form">
                <form id="save" method="POST" action="{{ route('expense.save') }}">
                    @csrf

                    <x-form.input.text
                        name="name"
                        class="name"
                        label="{{ __('name') }}"
                        placeholder="{{ __('e.g. toilet paper') }}"
                        required
                    />

                    <x-form.input.text
                        name="amount"
                        class="amount"
                        label="{{ __('amount') }}"
                        placeholder=""
                        required
                        suffix="zł"
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
