<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
    <h3>Menu</h3>
    <a href="/">Dashboard</a>

    @auth
        @canany(['isAdmin', 'isUser'])
            <a href="{{ route('expense') }}" class="text-capitalize">{{ __('expenses') }}</a>
            <a href="{{ route('billing') }}" class="text-capitalize">{{ __('billings') }}</a>
            @can('isAdmin')
                <a href="{{ route('admin.tenant') }}" class="text-capitalize">{{ ucfirst(__('tenants')) }}</a>
                <a href="{{ route('admin.payment') }}" class="text-capitalize">{{ __('payments') }}
                    / {{ __('payouts') }}</a>
            @endcan
        @endcanany

        <a href="{{ route('logout') }}" class="text-capitalize"
           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            {{ __('logout') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    @else
        <a href="{{ route('login') }}" class="text-capitalize">{{ __('login') }}</a>
    @endauth
</nav>
