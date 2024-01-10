@extends('layouts.app')

@section('content')
    <section id="dashboard">
        <div class="row">
            @auth
                @canany(['isAdmin', 'isUser'])
                    <div class="col-12 col-xl-4">
                        <div class="drager">
                            <h3>{{ ucfirst(__('current expenses')) }}</h3>
                            <div id="participant"></div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-8">
                        <div class="drager">
                            <h3>{{ ucfirst(__('balance history')) }}</h3>
                            <div id="balance"></div>
                        </div>
                    </div>
                @else
                    <div class="col-12">
                        <h1 class="text-center">{{ __('Wait for verification') }}</h1>
                    </div>
                @endcanany
            @else
                <div class="col-12">
                    <h1 class="text-center">{{ __('Tell my friend and come in') }}</h1>
                </div>
            @endauth
        </div>
    </section>
@endsection
