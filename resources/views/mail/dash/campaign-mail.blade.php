<x-mail::message>
{!! $campaign->message !!}

@if($campaign->url)
        <x-mail::button :url="$url">
            Acessar
        </x-mail::button>
@endif

</x-mail::message>
