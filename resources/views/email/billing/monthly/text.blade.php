Rozliczenie dla {{ $user->firstname }} {{ $user->lastname }} na dzień {{ \Carbon\Carbon::now()->format('d.m.Y') }}

{{ ucfirst(__('expenses')) }}:

    {{ ucfirst(__('name')) }}	{{ ucfirst(__('amount')) }}	{{ ucfirst(__('date')) }}	{{ ucfirst(__('person')) }}

@foreach($expenses as $detail)
    {{ mb_strtoupper($detail['name']) }}	{{ number_format($detail['amount'], 2, ".", ",") }} zł	{{ $detail['created_at'] }}	{{ $detail['user']->firstname }} {{ $detail['user']->lastname }}	@if($detail['canceled']) {{ mb_strtoupper(__('expense')) }} {{ mb_strtoupper(__('canceled')) }} @endif

@endforeach

{{ ucfirst(__('billing')) }}:

{{ ucfirst(__('beginning balance')) }} @if($billing->getArrears() >= 0){{ '(' . mb_strtoupper(__('overpayment')) . '):' }}@else{{ '(' . mb_strtoupper(__('underpayment')) . '):' }}@endif {{ number_format($billing->getArrears(), 2, ".", ",") }} zł
{{ ucfirst(__('your expenses')) }}: {{ number_format($billing->getExpense(), 2, ".", ",") }} zł
{{ ucfirst(__('expenditures per head')) }}: {{ number_format($billing->getExpensePerCapita(), 2, ".", ",") }} zł
@if($billing->getPayment() >= 0){{ ucfirst(__('registered payment')) }}@else{{ ucfirst(__('registered payout')) }}@endif: {{ number_format($billing->getPayment(), 2, ".", ",") }} zł
{{ ucfirst(__('your current balance')) }} @if($billing->getCumulativeBalance() >= 0){{ '(' . mb_strtoupper(__('overpayment')) .')' }}@else{{ '(' . mb_strtoupper(__('underpayment')) .')' }}@endif: {{ number_format($billing->getCumulativeBalance(), 2, ".", ",") }} zł

NIEDOPŁATĘ proszę uregulować poprzez https://revolut.me/rafa83ciq
NADPŁATA automatycznie przechodzi na następny miesiąc. Ewentualnie na życzenie robię zwrot na wskazany rachunek lub RevolutTag.
