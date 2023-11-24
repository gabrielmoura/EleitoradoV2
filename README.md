# Programa de gerenciamento politico

<p align="center">

[![wakatime](https://wakatime.com/badge/github/gabrielmoura/EleitoradoV2.svg)](https://wakatime.com/badge/github/gabrielmoura/EleitoradoV2)
</p>
<p align="center">

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![Livewire](https://img.shields.io/badge/livewire-%231572B6.svg?style=for-the-badge&logo=livewire&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Vite](https://img.shields.io/badge/vite-%23646CFF.svg?style=for-the-badge&logo=vite&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/postgresql-%23336791.svg?style=for-the-badge&logo=postgresql&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![Redis](https://img.shields.io/badge/redis-%23DD0031.svg?style=for-the-badge&logo=redis&logoColor=white)
</p>


## Instalação Heroku

* https://devcenter.heroku.com/articles/getting-started-with-laravel
* https://devcenter.heroku.com/articles/heroku-postgresql#connecting-in-php

```ini
web: heroku-php-nginx public/
Worker: php artisan queue:work
```

## Rodando em Desenvolvimento

* https://laravel.com/docs/10.x/sail#installation

```bash
sail up -d
```

## Rodando em Produção

* https://laravel.com/docs/10.x/deployment#introduction

```bash
php artisan optimize
php artisan event:cache
```
