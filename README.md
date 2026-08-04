# Danger-Online-php

Sistema web para la gestión de cibercafés desarrollado con Laravel.

## Tecnologías

- PHP 8.4
- Laravel 12
- MySQL
- Laravel Sail
- Docker
- Vite
- Blade

## Requisitos

- Docker Desktop
- Git

No es necesario instalar PHP, Composer o MySQL localmente si se utiliza Laravel Sail.

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/dunlk/danger-online-php.git
cd danger-online-php
```

### 2. Copiar el archivo de entorno

```bash
cp .env.example .env
```

### 3. Instalar dependencias

```bash
composer install
```

o si no tienes Composer instalado:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install
```

### 4. Levantar los contenedores

```bash
./vendor/bin/sail up -d
```

### 5. Generar la clave de Laravel

```bash
./vendor/bin/sail artisan key:generate
```

### 6. Ejecutar migraciones

```bash
./vendor/bin/sail artisan migrate
```

### 7. Instalar dependencias de Node

```bash
./vendor/bin/sail npm install
```

### 8. Ejecutar Vite

```bash
./vendor/bin/sail npm run dev
```

La aplicación estará disponible en:

```
http://localhost
```

---

## Comandos útiles

Levantar contenedores

```bash
./vendor/bin/sail up -d
```

Detener contenedores

```bash
./vendor/bin/sail down
```

Ver contenedores

```bash
./vendor/bin/sail ps
```

Ejecutar Artisan

```bash
./vendor/bin/sail artisan
```

Instalar paquetes Composer

```bash
./vendor/bin/sail composer require paquete
```

Ejecutar NPM

```bash
./vendor/bin/sail npm run dev
```

---

## Estructura del proyecto

```
app/
database/
resources/
routes/
storage/
tests/
```

---

## ERD

                    USERS

┌────────────────────────────────────┐
│ id (PK) │
│ name │
│ email │
│ password │
│ role │
│ remember_token │
│ created_at │
│ updated_at │
└────────────────────────────────────┘
│
│ 1
│
│
│ N
RESERVATIONS
┌────────────────────────────────────┐
│ id (PK) │
│ user_id (FK) │
│ computer_id (FK) │
│ reservation_date │
│ start_time │
│ hours │
│ status │
│ notes │
│ created_at │
│ updated_at │
└────────────────────────────────────┘
▲
│
│ N
│
│
│ 1
COMPUTERS
┌────────────────────────────────────┐
│ id (PK) │
│ category_id (FK) │
│ name (PC-01) │
│ description │
│ processor │
│ ram │
│ graphics │
│ storage │
│ monitor │
│ hourly_price │
│ status │
│ image │
│ created_at │
│ updated_at │
│ deleted_at │
└────────────────────────────────────┘
▲
│
│ N
│
│
│ 1
CATEGORIES
┌────────────────────────────────────┐
│ id (PK) │
│ name │
│ description │
│ created_at │
│ updated_at │
└────────────────────────────────────┘

---

## Equipo

- Maria Cueva
- Rodrigo Aguilar
- Milton Ytusaca
