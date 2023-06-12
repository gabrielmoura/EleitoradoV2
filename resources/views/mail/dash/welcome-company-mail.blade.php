<x-mail::message>
# Bem-vindo a {{$companyName}}

Clicando no botão abaixo você será redirecionado para a página de login do sistema.

Use o email {{$user->email}} e a senha <x-mail::password :color="'red'" > {{$password}}</x-mail::password> para acessar o sistema.

<x-mail::button :url="$url">
Acessar
</x-mail::button>

Atenciosamente,<br>
{{ config('app.name') }}
</x-mail::message>
