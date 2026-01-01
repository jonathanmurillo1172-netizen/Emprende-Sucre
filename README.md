# Guía de Instalación

Este proyecto ha sido diseñado para ser fácilmente desplegable en entornos locales usando **Laragon** o cualquier servidor LAMP.

## Requisitos Previos

*   PHP 8.2+
*   Composer
*   Node.js & NPM
*   MySQL

## Pasos de Instalación (Entorno Local / Dev)

### 1. Clonar el repositorio

```bash
git clone https://github.com/tu-usuario/emprende-sucre.git
cd emprende-sucre
```

### 2. Instalar dependencias de Backend

```bash
composer install
```

### 3. Instalar dependencias de Frontend

```bash
npm install
```

### 4. Configurar Entorno

*   Copia el archivo de configuración: `cp .env.example .env` (o copiar y pegar manualmente).
*   Configura tu base de datos en el archivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=casuistica-proyecto
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Inicializar Base de Datos y Storage

```bash
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

### 6. Ejecutar Proyecto

*   En una terminal: `npm run dev`
*   En otra terminal (o usando Laragon): `php artisan serve`

## Credenciales de Acceso

El sistema viene precargado con los siguientes usuarios para pruebas:

| Rol | Email | Contraseña |
| :--- | :--- | :--- |
| **Administrador** | admin@sucre.com | 123456 |


> **Nota:** El sistema instala por defecto usuarios de prueba. Para probar los roles, utilice las credenciales anteriores tras ejecutar la migración con seeds.

## Licencia y Créditos

Desarrollado por **Jonathan Murillo** para la asignatura de **Calidad de Software**. *Instituto Superior Universitario Sucre - 2026*
