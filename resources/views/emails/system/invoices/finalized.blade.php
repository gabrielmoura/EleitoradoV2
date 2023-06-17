<x-mail::message>
# Fatura de assinatura

Uma nova fatura para sua assinatura está disponível.

Consulte a fatura em anexo ou visite a página de faturamento.

<x-mail::button :url="config('app.url')">
Página de Faturamento
</x-mail::button>

Atenciosamente,<br>
{{ config('app.name') }}
</x-mail::message>
