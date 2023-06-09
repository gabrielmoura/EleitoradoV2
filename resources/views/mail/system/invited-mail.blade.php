<x-mail::message>
# Convite ao Sistema

Clicando no botão abaixo você será redirecionado para a página de cadastro do sistema.

<x-mail::button :url="$url">
Criar Conta
</x-mail::button>

Seu convite expira em {{ $expiration }}.

Atenciosamente,<br>
{{ config('app.name') }}
</x-mail::message>
