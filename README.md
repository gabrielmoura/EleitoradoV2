# Programa de gerenciamento politico

- https://php-flasher.io/livewire/
- https://laravel-livewire.com/docs/2.x/quickstart
- https://rappasoft.com/docs/laravel-livewire-tables/v2/introduction

## Cosiderar:
* https://darkghosthunter.medium.com/laravel-you-can-now-use-uuid-and-ulid-4ce9d3792fcb

## Instalação Heroku
* https://devcenter.heroku.com/articles/getting-started-with-laravel
* https://devcenter.heroku.com/articles/heroku-postgresql#connecting-in-php

```ini
web: heroku-php-nginx public/
Worker: php artisan queue:work
```

## Rodando em Desenvolvimento
* https://laravel.com/docs/8.x/sail#installation

```bash
sail up -d
```

## Rodando em Produção
* https://laravel.com/docs/8.x/deployment#introduction

```bash
php artisan optimize
```

