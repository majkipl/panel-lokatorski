{{ ucfirst(__('recorded expenses')) }}:

    {{ ucfirst(__('name')) }}	{{ ucfirst(__('amount')) }}	{{ ucfirst(__('date')) }}	{{ ucfirst(__('person')) }}

@foreach($expenses as $detail)
    {{ mb_strtoupper($detail['name']) }}	{{ number_format($detail['amount'], 2, ".", ",") }} zł	{{ $detail['created_at'] }}	{{ $detail['user']->firstname }} {{ $detail['user']->lastname }}	@if($detail['canceled']) {{ mb_strtoupper(__('expense')) }} {{ mb_strtoupper(__('canceled')) }} @endif
@endforeach
