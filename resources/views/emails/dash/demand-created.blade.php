<x-mail::message>
# Demanda criada

{{ $demand->name }}

{{ $demand->description }}

<x-mail::button :url="route('dash.demand.show',['demand'=>$demand->pid])">
Ver demanda
</x-mail::button>

Obrigado,<br>
{{ config('app.name') }}
</x-mail::message>
