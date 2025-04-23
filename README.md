# 🏡 Laravel 11 - Gestor de Propiedades Inmobiliarias

Esta es una aplicación web construida con Laravel 11 que permite gestionar propiedades inmobiliarias. El proyecto se inspira en portales como Idealista y está centrado en el desarrollo backend, con funcionalidades básicas de frontend para la administración.

## ✨ Características

- ✅ CRUD completo de propiedades
- ✅ Relación dinámica entre provincias y ciudades
- 🧪 Construido con Laravel 11 y Bootstrap CSS

---

## ⚙️ Requisitos

- PHP >= 8.2
- Composer
- SQLite3
- Laravel 11

## 🚀 Instalación

1. **Comandos para lanzar la aplicacion, en este orden**

```bash
git clone https://github.com/sergiovivart/inmoVivart.git
cd inmoVivart
cd inmobiliaria
composer install
php artisan migrate
php artisan key:generate
php artisan serve
```

# Una ves lanzado el servidor.

- http://127.0.0.1:8000/inmuebles -> direccion con lsitado de inmuebles.
- http://127.0.0.1:8000/admin -> panel de administrador para crear nuevos inmuebles.
<<<<<<< HEAD
- _Importante_ : recuerda crear una provincia y asignarle su ciudad antes de crear alguna nueva propiedad.
=======
- *Importante* : recuerda crear una provincia y asignarle su ciudad antes de crear alguna nueva propiedad.
>>>>>>> 27138342bc994fc570e9910e9b9edfae52ae96f9
