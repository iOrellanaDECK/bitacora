# Bitácora

Catálogo público de proyectos de [Ismael Orellana](https://github.com/iOrellanaDECK).  
Laravel 13 + PHP 8.5 + SQLite. En construcción, aprendiendo el stack con un producto real.

> English: a public project log built with Laravel 13. Work in progress — routes, Blade, controllers and Eloquent, one step at a time.

## Qué es

Una bitácora web donde cada entrada es un proyecto: nombre, stack, estado y un resumen. Sirve como portafolio vivo (no una landing estática) y como práctica de Laravel.

**Ahora:** skeleton de Laravel 13, servidor local OK.  
**Siguiente:** rutas, Blade, controladores, SQLite y Eloquent.

## Stack

| Pieza | Versión |
| --- | --- |
| PHP | 8.5 |
| Laravel | 13 |
| Base de datos | SQLite |
| Vistas | Blade |

## Cómo correrlo en local

Requisitos: PHP 8.5+ con `zip`, `fileinfo`, `pdo_sqlite`, `sqlite3`, y Composer 2.

```powershell
git clone https://github.com/iOrellanaDECK/bitacora.git
cd bitacora
composer install
copy .env.example .env
php artisan key:generate
php artisan serve
```

Abrir [http://127.0.0.1:8000](http://127.0.0.1:8000).

## Estado

- [x] Entorno PHP + Composer
- [x] Proyecto Laravel 13
- [x] Servidor local (`php artisan serve`)
- [ ] Rutas y vistas Blade
- [ ] Controladores
- [ ] Modelo Eloquent + migraciones SQLite
- [ ] Listado y ficha de proyectos

## Autor

**Ismael Orellana Castillo** — [github.com/iOrellanaDECK](https://github.com/iOrellanaDECK)
