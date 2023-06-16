<x-mail::message>
# Subscription invoice

A new invoice for your subscription is available.

See the attached invoice, or visit your billing portal.

<x-mail::button :url="config('app.url')">
Billing portal
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
