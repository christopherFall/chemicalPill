# Chemical Pill

Aplicación web para gestión de medicamentos (listar, crear, editar, eliminar) construida con **Laravel** (backend) y **Vue** (frontend) usando **Vite**. El proyecto está organizado para un desarrollo local rápido, despliegue sencillo y un frontend moderno.

## 🧱 Stack Tecnológico

- **Backend:** Laravel (PHP 8.2+ recomendado)
- **Frontend:** Vue 3 (con Vite y TypeScript)
- **Plantillas:** Blade (integradas con Vue cuando aplica)
- **Estilos:** Tailwind CSS (o CSS clásico, según configuración)
- **Herramientas de Dev:**
  - **Vite** para el build y HMR
  - **ESLint** / **Prettier** para linting y formateo
- **Base de datos:** MySQL/MariaDB (configurable en `.env`)
- **Testing:** PHPUnit


## 📁 Estructura del Proyecto

.
├─ app/                # Código del backend (Modelos, Controladores, Middlewares)
├─ bootstrap/          # Carga de Laravel
├─ config/             # Configuración de la app
├─ database/           # Migrations, Seeders, Factories
├─ public/             # Raíz pública (index.php, assets compilados)
├─ resources/
│  ├─ views/           # Vistas Blade
│  └─ js/              # Código Vue/TS y punto de entrada Vite
├─ routes/
│  ├─ web.php          # Rutas web
│  └─ api.php          # Rutas API
├─ storage/            # Archivos generados por la app
├─ tests/              # PHPUnit tests
├─ .env.example        # Variables de entorno de ejemplo
├─ composer.json       # Dependencias PHP
├─ package.json        # Dependencias JS
├─ vite.config.ts      # Configuración de Vite
└─ tsconfig.json       # Configuración de TypeScript

## ✅ Requisitos

- **PHP** 8.2 o superior
- **Composer** 2.x
- **Node.js** 18+ (LTS recomendado)
- **NPM** 9+ (o pnpm/yarn)
- **MySQL/MariaDB** u otra BD compatible

## 🚀 Instalación y uso en local

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/christopherFall/chemicalPill.git
   cd chemicalPill


2. **Instalar dependencias**


   composer install
   npm install

3. **Configurar variables de entorno**

   cp .env.example .env

   Editar `.env` con tus credenciales de base de datos:

   ```env
   APP_NAME="Chemical Pill"
   APP_ENV=local
   APP_KEY=
   APP_URL=http://localhost

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=chemical_pill
   DB_USERNAME=usuario
   DB_PASSWORD=contraseña
   ```

4. **Generar clave de aplicación**

   php artisan key:generate

5. **Migraciones y seeders (opcional)**

   php artisan migrate
   # php artisan db:seed

6. **Crear enlace de storage**

   php artisan storage:link

7. **Levantar el servidor de desarrollo**

   * Backend (Laravel):

     php artisan serve

   * Frontend (Vite):

     npm run dev

## 🧭 Rutas importantes

* **Web:** `routes/web.php`
* **API:** `routes/api.php`


## 🖼️ Frontend

* **Blade:** `resources/views/`
* **Vue/TS:** `resources/js/`
* **Estilos:** configurados en `postcss.config.js` y `tailwind.config.js`

## 🧪 Tests

php artisan test
# o
./vendor/bin/phpunit

## 🧹 Lint y Formato

# Lint
npm run lint

# Formateo
npm run format


## 🛡️ Variables sensibles

* Nunca subir `.env` al repositorio
* Usar `.env.example` como plantilla
* Configurar credenciales seguras para BD y servicios externos


## 📄 Licencia

Este proyecto puede distribuirse bajo la licencia que el autor decida.


## ✍️ Autor

**Christopher Ramirez**
