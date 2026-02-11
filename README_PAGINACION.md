# Sistema de Paginación Lado del Servidor - Guía de Configuración

## 📋 Descripción

Este proyecto implementa un sistema completo de paginación lado del servidor para tres páginas HTML:
- **circulares.html** - Listado de circulares y comunicados
- **funciones.html** - Manuales de funciones
- **listadoprotocolo.html** - Protocolos técnicos (formato tarjetas)

## 🚀 Características

✅ **Backend PHP** con endpoints RESTful  
✅ **Base de datos MySQL** con consultas optimizadas  
✅ **Paginación dinámica** sin recargar la página  
✅ **10 registros por página** (configurable)  
✅ **Controles de navegación** (Primera, 1, 2, 3... Última)  
✅ **Texto informativo** "Mostrando X al Y de Z registros"  
✅ **Diseño responsive** compatible con móviles  
✅ **Protección XSS** con escape de HTML  
✅ **Manejo de errores** con mensajes amigables

## 📁 Estructura de Archivos

```
MENU/
├── Backend (PHP)
│   ├── db_config.php           # Configuración de base de datos
│   ├── api_circulares.php      # API para circulares
│   ├── api_funciones.php       # API para funciones
│   └── api_protocolos.php      # API para protocolos
│
├── Frontend (HTML)
│   ├── circulares.html         # Página de circulares con paginación
│   ├── funciones.html          # Página de funciones con paginación
│   └── listadoprotocolo.html   # Página de protocolos con paginación
│
└── Database
    └── database_schema.sql     # Script SQL para crear tablas
```

## ⚙️ Configuración Paso a Paso

### 1. Configurar la Base de Datos

#### Opción A: Usando MySQL Workbench o phpMyAdmin

1. Abre tu cliente MySQL
2. Ejecuta el archivo `database_schema.sql`:
   ```sql
   -- El archivo creará:
   -- - Base de datos: tecnet_db
   -- - Tabla: circulares
   -- - Tabla: funciones
   -- - Tabla: protocolos
   -- - Datos de ejemplo
   ```

#### Opción B: Desde línea de comandos

```bash
mysql -u root -p < database_schema.sql
```

### 2. Configurar Credenciales de Base de Datos

Edita el archivo `db_config.php` y actualiza las credenciales:

```php
define('DB_HOST', 'localhost');      // Tu servidor MySQL
define('DB_NAME', 'tecnet_db');      // Nombre de tu base de datos
define('DB_USER', 'root');           // Tu usuario MySQL
define('DB_PASS', '');               // Tu contraseña MySQL
```

### 3. Configurar Servidor PHP

#### Opción A: Usando XAMPP/WAMP

1. Copia todos los archivos a la carpeta `htdocs` (XAMPP) o `www` (WAMP)
2. Inicia Apache y MySQL desde el panel de control
3. Accede a: `http://localhost/MENU/circulares.html`

#### Opción B: Usando PHP Built-in Server

```bash
cd c:\Users\monitor\Documents\MENU
php -S localhost:8000
```

Luego accede a: `http://localhost:8000/circulares.html`

### 4. Verificar la Instalación

1. Abre `circulares.html` en tu navegador
2. Deberías ver:
   - ✅ Spinner de carga inicial
   - ✅ Lista de circulares
   - ✅ Controles de paginación en la parte inferior
   - ✅ Texto "Mostrando registros del 1 al X de un total de Y"

## 🔧 Personalización

### Cambiar el Número de Registros por Página

En cada archivo HTML, modifica la constante:

```javascript
const RECORDS_PER_PAGE = 10; // Cambia a 20, 50, etc.
```

### Cambiar la URL del API

Si tus archivos PHP están en una carpeta diferente:

```javascript
// circulares.html
const API_URL = 'ruta/a/api_circulares.php';

// funciones.html
const API_URL = 'ruta/a/api_funciones.php';

// listadoprotocolo.html
const API_URL = 'ruta/a/api_protocolos.php';
```

### Personalizar Estilos de Paginación

Los estilos CSS están en cada archivo HTML dentro de la sección `<style>`:

```css
/* Busca la sección: PAGINATION STYLES */
.page-btn {
    /* Personaliza colores, tamaños, etc. */
}
```

## 📊 Estructura de la Base de Datos

### Tabla: circulares
```sql
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- titulo (VARCHAR 255)
- descripcion (TEXT)
- url (VARCHAR 500)
- fecha_creacion (DATETIME)
- activo (TINYINT)
```

### Tabla: funciones
```sql
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- titulo (VARCHAR 255)
- descripcion (TEXT)
- url (VARCHAR 500)
- fecha_creacion (DATETIME)
- activo (TINYINT)
```

### Tabla: protocolos
```sql
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- titulo (VARCHAR 255)
- descripcion (TEXT)
- icono (VARCHAR 50)
- url (VARCHAR 500)
- fecha_actualizacion (VARCHAR 50)
- estado (VARCHAR 50)
- activo (TINYINT)
```

## 🔍 Solución de Problemas

### Error: "Error al cargar los datos"

**Causa**: El servidor PHP no está ejecutándose o la base de datos no está configurada.

**Solución**:
1. Verifica que Apache/PHP esté ejecutándose
2. Verifica que MySQL esté ejecutándose
3. Revisa las credenciales en `db_config.php`
4. Abre la consola del navegador (F12) para ver errores detallados

### Error: "HTTP error! status: 404"

**Causa**: Los archivos PHP no se encuentran en la ruta correcta.

**Solución**:
1. Verifica que los archivos `.php` estén en la misma carpeta que los `.html`
2. Verifica la URL del API en el código JavaScript

### Error: "Access to fetch has been blocked by CORS policy"

**Causa**: Problema de CORS al ejecutar archivos localmente.

**Solución**:
1. Usa un servidor web (XAMPP, WAMP, o `php -S`)
2. No abras los archivos directamente con `file://`

### Los datos no se muestran

**Solución**:
1. Verifica que ejecutaste el script SQL
2. Verifica que las tablas tengan datos:
   ```sql
   SELECT * FROM circulares;
   SELECT * FROM funciones;
   SELECT * FROM protocolos;
   ```

## 📱 Compatibilidad

- ✅ Chrome/Edge (últimas versiones)
- ✅ Firefox (últimas versiones)
- ✅ Safari (últimas versiones)
- ✅ Dispositivos móviles (responsive design)

## 🔐 Seguridad

El sistema incluye:
- ✅ Prepared statements (prevención de SQL injection)
- ✅ Escape de HTML (prevención de XSS)
- ✅ Validación de parámetros
- ✅ Manejo de errores sin exponer información sensible

## 📝 Agregar Nuevos Registros

### Vía SQL

```sql
-- Agregar nueva circular
INSERT INTO circulares (titulo, descripcion, url) 
VALUES ('Título', 'Descripción', 'https://ejemplo.com');

-- Agregar nueva función
INSERT INTO funciones (titulo, descripcion, url) 
VALUES ('Título', 'Descripción', 'https://ejemplo.com');

-- Agregar nuevo protocolo
INSERT INTO protocolos (titulo, descripcion, icono, url, fecha_actualizacion, estado) 
VALUES ('Título', 'Descripción', '⚡', 'manual.html', 'Feb 2026', 'Publicado');
```

### Vía phpMyAdmin

1. Selecciona la tabla correspondiente
2. Click en "Insertar"
3. Completa los campos
4. Click en "Continuar"

## 🎯 Próximos Pasos

1. ✅ Implementación completada
2. ⏳ Pruebas en servidor local
3. ⏳ Pruebas en diferentes navegadores
4. ⏳ Despliegue a producción

## 💡 Soporte

Si encuentras problemas:
1. Revisa la consola del navegador (F12 → Console)
2. Revisa los logs de PHP
3. Verifica la configuración de la base de datos

---

**Versión**: 1.0  
**Fecha**: Febrero 2026  
**Desarrollado para**: TECNET.C.A.
