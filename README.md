# Aventones ISW613

Aplicacion web desarrollada como parte del curso ISW613. El sistema permite la gestion de viajes compartidos entre usuarios, implementando con PHP, XAMPP y JavaScript.

## Descripcion general

Aventones ISW613 es una plataforma web que conecta conductores y pasajeros para coordinar viajes. El sistema permite registrar usuarios, crear y administrar vehiculos, publicar y reservar viajes, y manejar estados de las solicitudes. Incluye autenticacion, validacion de datos y envio de correos electronicos.

## Caracteristicas principales

- Registro y autenticacion de usuarios
- Roles diferenciados (chofer y pasajero)
- Administracion de vehiculos
- Publicacion y reserva de viajes
- Sistema de estados de reserva (pendiente, aceptada, rechazada)
- Envio de notificaciones por correo
- Panel de administracion basico
- Scripts de mantenimiento (notificacion de reservas pendientes)

## Estructura del proyecto
```
Proyecto-1 
├─ actions
│  ├─ auth
│  │  ├─ authController.php
│  │  └─ usuario.php 
│  ├─ reserves
│  │  ├─ reserveController.php
│  │  └─ reserve.php
│  ├─ rides
│  │  ├─ rideController.php
│  │  └─ ride.php
│  ├─ vehicles
│  │  ├─ vehicleController.php
│  │  └─ vehicle.php
│  ├─ services
│  │  └─ mailService.php
│  └─ handler.php
├─ assets
│  ├─ userPhotos/
│  └─ vehiclePhotos/
├─ common
│  ├─ connection.php
│  └─ authGuard.php
├─ css
│  ├─ base.css
│  ├─ layout.css
│  ├─ components
│  │  └─ forms.css
│  └─ sections
│     └─ profile.css
├─ js
│  ├─ auth
│  │  └─ login.js
│  ├─ rides
│  │  └─ rides.js
│  ├─ vehicles
│  │  └─ vehicles.js
│  └─ reserve
│     └─ reserve.js
├─ pages
│  ├─ components
│  │  └─ header.php
│  ├─ login.php
│  ├─ rides.php
│  └─ profile.php
├─ scripts
│  └─ driver_notify.php
├─ common/
│  └─ PHPMailer/
│     └─ PHPMailer.php
├─ index.php
└─ README.md
```

## Scripts de consola
El proyecto incluye scripts para tareas automatizadas.
```
php scripts/driver_notify.php 120
```
Este comando busca reservas pendientes con mas de 120 minutos y envia un correo de aviso.