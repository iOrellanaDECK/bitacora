# Bitácora

Catálogo público de proyectos de [Ismael Orellana](https://github.com/iOrellanaDECK).  
Laravel 13 + PHP 8.5 + SQLite + Tailwind CSS 4. En construcción, aprendiendo el stack con un producto real.

> English: a public project log built with Laravel 13. Work in progress — routes, Blade, controllers and Eloquent, one step at a time.

## Qué es

Una bitácora web donde cada entrada es un proyecto: nombre, stack, estado y un resumen. Sirve como portafolio vivo (no una landing estática) y como práctica de Laravel.

## Funcionalidades

- **Listado de proyectos** con tarjetas responsive y badges de estado
- **Ficha detallada** de cada proyecto con stack, resumen y fechas
- **Crear** nuevos proyectos vía formulario con validación
- **Editar** proyectos existentes
- **Eliminar** proyectos con confirmación
- **Mensajes flash** de éxito tras cada acción
- **Diseño responsive** con Tailwind CSS 4

## Stack

| Pieza | Versión |
| --- | --- |
| PHP | 8.5 |
| Laravel | 13 |
| Base de datos | SQLite |
| Vistas | Blade |
| CSS | Tailwind CSS 4 |
| Build | Vite |

## Cómo correrlo en local

Requisitos: PHP 8.5+ con `zip`, `fileinfo`, `pdo_sqlite`, `sqlite3`, Composer 2 y Node.js.

```powershell
git clone https://github.com/iOrellanaDECK/bitacora.git
cd bitacora
composer install
npm install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
```

Para desarrollo (servidor + Vite en paralelo):

```powershell
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

Abrir [http://127.0.0.1:8000](http://127.0.0.1:8000).

## Estructura del proyecto

```
app/
├── Http/Controllers/
│   └── ProyectoController.php   # CRUD completo (7 métodos)
├── Models/
│   └── Proyecto.php              # Modelo Eloquent
database/
├── migrations/
│   └── create_proyectos_table    # id, titulo, stack, estado, resumen
├── seeders/
│   └── ProyectoSeeder.php        # 6 proyectos de ejemplo
resources/views/
├── layouts/app.blade.php         # Layout maestro con Tailwind
├── proyectos/
│   ├── index.blade.php           # Grid de tarjetas
│   ├── show.blade.php            # Ficha detallada
│   ├── create.blade.php          # Formulario de creación
│   ├── edit.blade.php            # Formulario de edición
│   └── _form.blade.php           # Partial reutilizable
routes/
└── web.php                       # Route::resource('proyectos')
```

## Estado

- [x] Entorno PHP + Composer
- [x] Proyecto Laravel 13
- [x] Servidor local (`php artisan serve`)
- [x] Rutas RESTful y vistas Blade con Tailwind CSS
- [x] Controlador con CRUD completo
- [x] Modelo Eloquent + migraciones SQLite
- [x] Listado y ficha de proyectos
- [x] Formularios de creación y edición
- [x] Seeder con datos de ejemplo
- [ ] Validación con Form Requests
- [ ] Filtros y ordenamiento
- [ ] Tests

## Autor

**Ismael Orellana Castillo** — [github.com/iOrellanaDECK](https://github.com/iOrellanaDECK)
