# NovaMelody

**Autor:** Pablo Vigo Jiménez  
**Curso:** 2º DAW - 24/25 

## Índice

1. [Descripción](#descripción)  
2. [Características Principales](#características-principales)  
3. [Objetivos](#objetivos)  
   - [Objetivo General](#objetivo-general)  
   - [Objetivos Específicos](#objetivos-específicos)  
4. [Tecnologías Utilizadas](#tecnologías-utilizadas)  
   - [Frontend](#frontend)  
   - [Backend](#backend)  
   - [Infraestructura](#infraestructura)  
5. [Esquema E/R](#esquema-er)  
6. [Instalación y Configuración](#instalación-y-configuración)  
   - [Prerrequisitos](#prerrequisitos)  
   - [Clonar el Repositorio](#1-clonar-el-repositorio)  
   - [Configuración del Servidor Local](#2-configuración-del-servidor-local)  
   - [Configuración de Base de Datos](#3-configuración-de-base-de-datos)  
   - [Configuración de la Aplicación](#4-configuración-de-la-aplicación)  
   - [Permisos de Archivos Multimedia](#5-configurar-permisos-de-archivos-multimedia)  
   - [Activar Extensión PDO](#6-activar-extensión-pdo)  
   - [Acceder a la Aplicación](#7-acceder-a-la-aplicación)  
7. [Tutorial de Uso](#tutorial-de-uso)  
8. [Despliegue en AWS](#despliegue-en-aws)
   - [Configuración EC2](#configuración-ec2)  
   - [Instalación en Servidor](#instalación-en-servidor)  
   - [SSL con Certbot](#ssl-con-certbot)  
9. [URLs del Proyecto](#urls-del-proyecto)  
10. [Bitácora de Tareas](#bitácora-de-tareas)  
11. [Planes Futuros](#planes-futuros)  
12. [Bibliografía](#bibliografía)  
13. [Video Demostración](#video-demostración)

---

## Descripción

NovaMelody es una aplicación web de música urbana inspirada en Spotify, desarrollada completamente desde cero. La plataforma permite a los usuarios ver, escuchar y gestionar artistas, álbumes y canciones una forma fácil.

### Características Principales:
- **Búsqueda avanzada** de canciones, álbumes y artistas
- **Diseño completamente responsive**
- **Sistema de usuarios** con perfiles personalizados
- **Panel de administración** para gestión de contenido
- **Navegación SPA** (Single Page Application)
- **Certificados SSL** para conexiones seguras

---

## Objetivos

### Objetivo General
Hacer una aplicación web interactiva de música urbana que permita a los usuarios escuchar canciones, visualizar álbumes, ver su perfil y acceder a contenido multimedia.

### Objetivos Específicos
- **Diseño moderno** inspirado en Spotify
- **Barra de búsqueda** para contenido musical
- **Base de datos MySQL** para gestión eficiente
- **Implementación AJAX** para mayor rendimiento

---

## Tecnologías Utilizadas

### Frontend
| Tecnología | Versión | Uso |
|------------|---------|-----|
| ![HTML](https://img.shields.io/badge/HTML5-E34F26?style=flat&logo=html5&logoColor=white) | 5 | Estructura y multimedia |
| ![CSS](https://img.shields.io/badge/CSS3-1572B6?style=flat&logo=css3&logoColor=white) | 3 | Grid, Flexbox, animaciones |
| ![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=flat&logo=bootstrap&logoColor=white) | 5.3 | Diseño responsive |
| ![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat&logo=javascript&logoColor=black) | ES6 | Lógica frontend |
| ![Swiper](https://img.shields.io/badge/Swiper.js-6332F6?style=flat&logo=swiper&logoColor=white) | Latest | Carruseles optimizados |

### Backend
| Tecnología | Versión | Uso |
|------------|---------|-----|
| ![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white) | 8.2 | Servidor y lógica |
| ![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat&logo=mysql&logoColor=white) | 8.0 | Base de datos |
| ![Apache](https://img.shields.io/badge/Apache-D22128?style=flat&logo=apache&logoColor=white) | 2.4 | Servidor web |

### Infraestructura
| Servicio | Uso |
|----------|-----|
| ![AWS](https://img.shields.io/badge/AWS-232F3E?style=flat&logo=amazon-aws&logoColor=white) | Hosting y despliegue |
| **EC2** | Servidor web |
| **RDS Aurora** | Base de datos |
| **Elastic IP** | IP estática |
| **SSL Certificate** | Conexiones seguras |

---

## Esquema E/R

El diseño de la base de datos incluye las siguientes entidades principales:
- **Usuarios**
- **Canciones**
- **Álbumes**
- **Artistas**

**[Ver Esquema Completo](https://github.com/pvigjim0502/Proyecto_Spotify_DAW_24_25/blob/main/Esquema%20E-R%20de%20la%20base%20de%20datos.pdf)**

---

## Instalación y Configuración

### Prerrequisitos
- PHP 8.0+
- MySQL 8.0+
- Apache 2.4+

### 1. Clonar el Repositorio
```bash
git clone https://github.com/pvigjim0502/Proyecto_Spotify_DAW_24_25.git
cd Proyecto_Spotify_DAW_24_25/novamelody
```

### 2. Configuración del Servidor Local

#### XAMPP/WAMP
1. Copiar el proyecto a `www/`
2. Iniciar Apache y MySQL
3. Importar la base de datos desde `database/novamelody.sql`

### 3. Configuración de Base de Datos
```sql
-- Crear base de datos
CREATE DATABASE MUSICA_URBANA;

-- Importar estructura
mysql -u root -p MUSICA_URBANA < database/MUSICA_URBANA.sql
```

### 4. Configuración de la Aplicación
```php
// includes/config.php
<?php
define('DB_HOST', 'localhost');
define('DB_NOMBRE', 'MUSICA_URBANA');
define('DB_USUARIO', 'USUARIO');
define('DB_CONTRASENA', 'CONTRASEÑA');
define('CHARSET', 'utf8mb4');
?>
```

### 5. Configurar Permisos de Archivos Multimedia
```bash
# Dar permisos correctos a las carpetas reales
chmod 755 assets/audio assets/img

# Dar permisos de lectura a los archivos dentro
chmod -R 755 assets/audio/
chmod -R 755 assets/img/*

# Configurar PHP para subida de archivos
# En php.ini:
# upload_max_filesize = 50M
# post_max_size = 50M
# max_file_uploads = 20
```

### 6. Activar Extensión PDO
Para que la conexión a la base de datos funcione correctamente, asegúrate de que la extensión PDO esté activada en `php.ini`

```ini
extension=pdo_mysql
```

### 7. Acceder a la Aplicación
- **Enlace local:** `http://localhost/novamelody`

### Credenciales Administrador
```
- Usuario: admin
- Contraseña: admin
```

---

## Tutorial de Uso

Para poder usar la aplicación a profundidad, investiga este documento de
**[Manual de Usuario](https://docs.google.com/document/d/1EfhCC7-01DIy_IS1-1OYtSTaYs0h4oyV3iTE5RUh0CE/edit?usp=sharing)**

## Despliegue en AWS

### Configuración EC2
1. **Instancia:** Amazon Linux 2023 AMI
2. **Tipo:** t2.micro (Free Tier)
3. **Seguridad:** HTTP (80), HTTPS (443)

### Instalación en Servidor
```bash
# Actualizar sistema
sudo dnf update -y

# Instalar stack LAMP
sudo dnf install -y httpd php php-mysqli php-pdo php-pdo_mysql php-mbstring php-xml php-gd unzip

# Iniciar servicios
sudo systemctl start httpd
sudo systemctl enable httpd

# Desplegar aplicación
wget TU_REPOSITORIO_ZIP
unzip proyecto.zip -d /var/www/html/
sudo chown -R apache:apache /var/www/html/
sudo systemctl restart httpd
```

### SSL con Certbot
```bash
sudo dnf install certbot python3-certbot-apache -y
sudo certbot --apache
```

---

## URLs del Proyecto

| Recurso | URL |
|---------|-----|
| Aplicación Principal | [novamelody.duckdns.org](https://novamelody.duckdns.org/) |
| IP Elástica (SSL) | [54.227.162.8](https://54.227.162.8/) |
| Diseño en Canva | [Ver Diseño](https://github.com/pvigjim0502/Proyecto_Spotify_DAW_24_25/blob/main/P%C3%A1gina%20web%20Proyecto%20-%20Dise%C3%B1o.jpg) |
| Bitácora de Tareas | [Google Sheets](https://docs.google.com/spreadsheets/d/1yjZs7zs3Mi8EsoKz9oei54kmLi3yTnPL3QgPHWc4XNQ/edit?usp=sharing) |

---

## Bitácora de Tareas

Seguimiento completo del desarrollo del proyecto disponible en:
**[Google Sheets](https://docs.google.com/spreadsheets/d/1yjZs7zs3Mi8EsoKz9oei54kmLi3yTnPL3QgPHWc4XNQ/edit?usp=sharing)**

---

## Planes Futuros

### Mejoras Técnicas
-  **Mejorar diseño y adaptación** a móviles y tablets
-  **Añadir más contenido** para mejorar mi web para el SEO
-  **Ofrecer opciones de personalización** para los usuarios
-  **Mejorar la interfaz** para reproducir la música

---

## Bibliografía

### Documentación Técnica
- **HTML/CSS:** [HTML+CSS Documentacion](https://lenguajehtml.com/)
- **JavaScript:** [ES6+](https://www.w3schools.com/js/)
- **PHP:** [Official Documentacion](https://www.php.net/docs.php)
- **Bootstrap:** [Bootstrap 5 Documentacion](https://getbootstrap.com/docs/5.3/getting-started/introduction/)
- **Swiper.js:** [API Documentacion](https://swiperjs.com/swiper-api)

### Servicios Cloud
- **AWS EC2:** [User Guía](https://docs.aws.amazon.com/ec2/)
- **AWS RDS:** [Aurora Documentacion](https://docs.aws.amazon.com/AmazonRDS/latest/AuroraUserGuide/)
- **SSL/TLS:** [Certbot](https://certbot.eff.org/)

### Herramientas de Desarrollo
- **MySQL:** [Reference Manual](https://downloads.mysql.com/docs/refman-5.0-es.pdf)
- **Apache:** [HTTP Server Documentacion](https://httpd.apache.org/docs/)

---

## Video Demostración

**[Ver Video Completo en YouTube](https://youtu.be/HfMCZRdz01M)**

### Contenido del Video
- Demostración de funcionalidades principales
- Tutorial de uso para usuarios
- Panel de administración
- Diseño responsive

---

*Última actualización: Junio 2025*
