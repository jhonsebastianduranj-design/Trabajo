# Actividad de Construcción Aplicada al Desarrollo Web

Sistema web en **PHP (MVC)** para la **gestión de pacientes** de la IPS ALMA VIDA, con autenticación y CRUD completo conectado a MySQL.

## Funcionalidades implementadas
- Login de usuario (autenticación básica con sesión).
- Registro de pacientes.
- Listado de pacientes.
- Edición de pacientes.
- Eliminación de pacientes.
- Captura de: nombre completo, tipo documento, dirección, teléfono, celular, fecha de nacimiento, edad, EPS, contacto adicional, parentesco, tipo de examen, empresa y fecha de examen.
- Validaciones en cliente con JavaScript (campos obligatorios y cálculo automático de edad).

## Estructura MVC
- `app/controllers`: controladores de autenticación y pacientes.
- `app/models`: acceso a datos con PDO.
- `app/views`: vistas HTML.
- `app/core`: clases base (Controlador y conexión DB).
- `public`: front controller (`index.php`) + CSS + JS.
- `database/schema.sql`: script de creación de base de datos.

## Requisitos
- PHP 8.1+
- MySQL 8+
- XAMPP (o Apache + PHP + MySQL)

## Instalación rápida
1. Crear la base de datos y tablas ejecutando:
   ```sql
   SOURCE database/schema.sql;
   ```
2. Ajustar credenciales de DB en `app/config/config.php`.
3. Publicar el proyecto apuntando el DocumentRoot a `public/`.
4. Ingresar al sistema con:
   - **Correo:** `admin@almavida.com`
   - **Contraseña:** `Admin123*`

## Ejecución local (sin Apache)
Desde la raíz del proyecto:
```bash
php -S 0.0.0.0:8000 -t public
```
Abrir `http://localhost:8000`.
