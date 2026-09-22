# 📓 Bitácora — Gestión de Proyectos con Laravel 13

Aplicación web completa y API RESTful desarrollada con **Laravel 13**, **PHP 8.5**, **Tailwind CSS** y **SQLite**.  
Diseñada como proyecto de portafolio técnico para demostrar buenas prácticas, arquitectura limpia y uso avanzado de los componentes clave de Laravel.

Autor: [Ismael Orellana](https://github.com/iOrellanaDECK)

---

## 🎯 Características y Demostración Técnica

Este proyecto demuestra los conceptos fundamentales y avanzados que se esperan en un desarrollo profesional con Laravel:

| Capacidad | Implementación en este proyecto |
|---|---|
| **Autenticación** | Implementada con **Laravel Breeze** (registro, login, perfil, recuperación de contraseña y sesiones seguras). |
| **Autorización (Policies)** | `ProyectoPolicy` garantiza que cualquier usuario/visitante pueda leer proyectos, pero solo el autor dueño pueda editarlos o eliminarlos. |
| **Relaciones Eloquent** | `User` 1:N `Proyecto` (`hasMany` / `belongsTo`) y `Proyecto` N:M `Etiqueta` (`belongsToMany` mediante tabla pivote `etiqueta_proyecto`). |
| **Validación Limpia** | Form Requests dedicados (`StoreProyectoRequest`, `UpdateProyectoRequest`) con mensajes personalizados y validación estricta de estados y campos. |
| **Query Scopes** | Scopes de consulta en Eloquent (`scopeBuscar`, `scopeEstado`, `scopeConEtiqueta`) para búsquedas en tiempo real y filtrado combinado. |
| **API RESTful** | Endpoints JSON en `/api/proyectos` con soporte de paginación, filtros de consulta y serialización mediante **API Resources** (`ProyectoResource`). |
| **Autenticación API** | Integración con **Laravel Sanctum** para autorizar operaciones de escritura en la API vía Bearer Token. |
| **Testing Automatizado** | **45 pruebas automatizadas (Feature Tests)** con **135 aserciones** que validan flujos web, autenticación, autorización por políticas, endpoints de API y filtros de búsqueda. |
| **Factories & Seeders** | Datos iniciales realistas con `ProyectoFactory`, `EtiquetaFactory`, `ProyectoSeeder` y `EtiquetaSeeder`. |
| **Frontend Moderno** | Vistas Blade reactivas estilizadas con **Tailwind CSS** y empaquetadas con **Vite**. |

---

## 📦 Stack Tecnológico

- **Framework:** Laravel 13
- **PHP:** 8.5+
- **Base de Datos:** SQLite (compatible out-of-the-box con MySQL / PostgreSQL)
- **API Tokens:** Laravel Sanctum
- **Auth:** Laravel Breeze
- **Frontend:** Blade Components + Tailwind CSS
- **Bundler:** Vite 8
- **Testing:** PHPUnit 12

---

## 🚀 Instalación y Ejecución Local

### Prerrequisitos
- PHP 8.3+ con extensiones `pdo_sqlite`, `sqlite3`, `fileinfo`, `mbstring`, `zip`.
- Composer 2+
- Node.js 18+ y npm

### Pasos

1. **Clonar repositorio:**
   ```powershell
   git clone https://github.com/iOrellanaDECK/bitacora.git
   cd bitacora
   ```

2. **Instalar dependencias de PHP y JavaScript:**
   ```powershell
   composer install
   npm install
   ```

3. **Configurar entorno:**
   ```powershell
   copy .env.example .env
   php artisan key:generate
   ```

4. **Ejecutar migraciones con seeders:**
   ```powershell
   php artisan migrate:fresh --seed
   ```
   > Esto creará las tablas, un usuario de prueba (`ismael@example.com` / `password`), etiquetas de tecnologías y 6 proyectos de ejemplo.

5. **Compilar assets y levantar el servidor:**
   ```powershell
   # En una terminal:
   php artisan serve

   # En otra terminal (para desarrollo en vivo):
   npm run dev
   ```

6. Abrir en el navegador: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🧪 Ejecución de Tests

El proyecto cuenta con cobertura completa de pruebas automatizadas:

```powershell
php artisan test
```

Salida esperada:
```
PASS  Tests\Feature\Api\ProyectoTest
✓ api lists projects with pagination
✓ api shows single project
✓ api filters by estado
✓ api searches projects
✓ api authenticated user can create project
✓ api unauthenticated user cannot create project
✓ api owner can update project
✓ api owner can delete project
✓ api stranger cannot update project

PASS  Tests\Feature\ProyectoTest
✓ guests can view project listing
✓ guests can view a single project
✓ guests cannot access create form
✓ authenticated user can create a project
✓ validation rejects empty fields
✓ owner can update their project
✓ owner can delete their project
✓ user cannot update another users project
✓ user cannot delete another users project
✓ projects can be filtered by estado
✓ projects can be searched by titulo

... Total: 45 passed (135 assertions)
```

---

## 🔌 API Endpoints

| Método | Endpoint | Descripción | Acceso |
|---|---|---|---|
| `GET` | `/api/proyectos` | Lista proyectos (paginado, filtros `?buscar=`, `?estado=`, `?etiqueta=`) | Público |
| `GET` | `/api/proyectos/{id}` | Detalle de un proyecto con autor y etiquetas | Público |
| `POST` | `/api/proyectos` | Crear proyecto | Requiere Sanctum (`auth:sanctum`) |
| `PUT` | `/api/proyectos/{id}` | Actualizar proyecto | Requiere Sanctum + Dueño |
| `DELETE` | `/api/proyectos/{id}` | Eliminar proyecto | Requiere Sanctum + Dueño |

---

## 📂 Arquitectura del Proyecto

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   │   └── ProyectoController.php  # Controlador REST API
│   │   ├── Auth/                       # Controladores Breeze (login, registro)
│   │   └── ProyectoController.php      # Controlador Web (CRUD + sync etiquetas)
│   ├── Requests/
│   │   ├── StoreProyectoRequest.php    # Validación de creación
│   │   └── UpdateProyectoRequest.php   # Validación de actualización
│   └── Resources/
│       └── ProyectoResource.php        # Formato JSON con relaciones condicionales
├── Models/
│   ├── Etiqueta.php                    # Modelo etiquetas (N:M)
│   ├── Proyecto.php                    # Modelo proyectos (scopes, belongsTo, belongsToMany)
│   └── User.php                        # Modelo usuario (hasMany proyectos)
└── Policies/
    └── ProyectoPolicy.php              # Reglas de autorización (view, update, delete)

database/
├── factories/
│   ├── EtiquetaFactory.php
│   ├── ProyectoFactory.php
│   └── UserFactory.php
├── migrations/
│   ├── 2026_09_21_172954_create_proyectos_table.php
│   ├── 2026_09_22_100000_add_user_id_to_proyectos_table.php
│   ├── 2026_09_22_100001_create_etiquetas_table.php
│   └── 2026_09_22_100002_create_etiqueta_proyecto_table.php
└── seeders/
    ├── DatabaseSeeder.php
    ├── EtiquetaSeeder.php
    └── ProyectoSeeder.php

resources/views/
├── layouts/
│   ├── app.blade.php                   # Layout principal
│   └── navigation.blade.php            # Navbar reactiva con estado de sesión
└── proyectos/
    ├── index.blade.php                 # Grid con buscador y filtros
    ├── show.blade.php                  # Detalle con permisos @can
    ├── create.blade.php                # Formulario nuevo
    ├── edit.blade.php                  # Formulario edición
    └── _form.blade.php                 # Partial reutilizable

tests/
└── Feature/
    ├── Api/
    │   └── ProyectoTest.php            # Pruebas completas de API REST
    └── ProyectoTest.php                # Pruebas completas de CRUD Web y Policies
```

---

## 👤 Autor

**Ismael Orellana Castillo**  
- GitHub: [@iOrellanaDECK](https://github.com/iOrellanaDECK)
