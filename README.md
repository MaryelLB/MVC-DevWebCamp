# DevWebCamp - Sitio Web para Conferencias de Desarrollo

DevWebCamp es una aplicación web diseñada para gestionar conferencias de desarrollo. Permite a los usuarios registrarse, adquirir boletos, realizar pagos a través de PayPal y acceder a contenido exclusivo. Además, cuenta con un panel de administración para la gestión de eventos, ponentes y usuarios.

## 🛠 Tecnologías Utilizadas

- **PHP 8** – Backend con enfoque en Programación Orientada a Objetos.
- **Arquitectura MVC** – Separación de responsabilidades en Modelos, Vistas y Controladores.
- **MySQL** – Base de datos relacional.
- **SASS/SCSS** – Preprocesador CSS.
- **Gulp** – Automatización de tareas de frontend.
- **JavaScript Vanilla** – Interactividad en el frontend.
- **Composer** – Gestión de dependencias PHP.
- **npm** – Gestión de dependencias frontend.
- **PayPal API** – Procesamiento de pagos.
- **Mailtrap** – Testing de correo electrónico.

## ⚙️ Funcionalidades

- Registro e inicio de sesión con verificación por correo.
- Compra de boletos con integración de PayPal.
- Panel de administración para eventos, ponentes y usuarios.
- Estadísticas y reportes del evento.
- Sistema de roles (administrador y asistente).
- Generación de códigos QR y selección de regalos.

## 🚀 Instalación

1. **Clona el repositorio:**

   ```bash
   git clone https://github.com/MaryelLB/MVC-DevWebCamp.git
   cd MVC-DevWebCamp
2. **Instala dependencias de PHP**
   ```bash
   composer install
3. **Instala dependencias frontend:**
   ```bash
    npm install

4. **Modifica el archivo .env dentro de la carpeta /includes**

5. **Usa el archivo devwebcamp.sql en tu gestor de base de datos (por ejemplo, phpMyAdmin o MySQL Workbench).**

6. **Compila los recursos frontend:**  
    ```bash
      npx gulp
7. **Ejecuta el servidor de desarrollo dentro de la carpeta public:**    
  ```bash
  cd public
  php -S localhost:3000





