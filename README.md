# login-cakephp
Repositório template de login

# Versão
CakePHP versão 3.8

# Recursos
  - AdminLTE
  - Fontawesome
  
# Banco de dados
  - Altere as configurações do banco em config/app.php linha 266
  - Banco de dados MySQL
  - Arquivo SQL do banco disponível em config/migrations/login.sql

# Envio de email
  - Descomente e altere as configurações de envio de email em src/Controller/LoginController.php
  
# CakePHP Application Skeleton

[![Build Status](https://img.shields.io/travis/cakephp/app/master.svg?style=flat-square)](https://travis-ci.org/cakephp/app)
[![Total Downloads](https://img.shields.io/packagist/dt/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app)

A skeleton for creating applications with [CakePHP](https://cakephp.org) 3.8.

## Installation

1. Download [Composer](https://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project --prefer-dist cakephp/app [app_name]`.

If Composer is installed globally, run

```bash
composer create-project --prefer-dist cakephp/app:^3.8
```

In case you want to use a custom app dir name (e.g. `/myapp/`):

```bash
composer create-project --prefer-dist cakephp/app:^3.8 myapp
```

You can now either use your machine's webserver to view the default home page, or start
up the built-in webserver with:

```bash
bin/cake server -p 8765
```

Then visit `http://localhost:8765` to see the welcome page.

## Configuration

To configure the application timezone, change the line below in `config/app.php`.
```bash
'defaultTimezone' => env('APP_DEFAULT_TIMEZONE', 'UTC'),
```

Set `America\Campo_Grande` for `UTC-4` or `America\Sao_Paulo` for `UTC-3`
