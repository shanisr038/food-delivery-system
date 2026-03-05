<x-mail::message>
# New Order Received!

**Order #{{ $order->id }}** has been placed at **{{ $order->restaurant->name ?? 'our restaurant' }}**.

## Customer Details
- **Name:** {{ $order->customer->name ?? 'Guest' }}
- **Email:** {{ $order->customer->email ?? 'N/A' }}

## Order Summary
@foreach($order->products as $item)
- {{ $item->name }} ({{ number_format($item->price / 100, 2) }} &euro;)
@endforeach

**Total: {{ number_format($order->total / 100, 2) }} &euro;**

<x-mail::button :url="route('home')">
View Order Dashboard
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>