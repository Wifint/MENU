-- Script SQL para crear las tablas necesarias para el sistema de paginación
-- Base de datos: tecnet_db

-- Crear base de datos (si no existe)
CREATE DATABASE IF NOT EXISTS tecnet_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tecnet_db;

-- Tabla de Circulares
CREATE TABLE IF NOT EXISTS circulares (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    url VARCHAR(500) NOT NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    activo TINYINT(1) DEFAULT 1,
    INDEX idx_fecha_creacion (fecha_creacion),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de Funciones
CREATE TABLE IF NOT EXISTS funciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    url VARCHAR(500) NOT NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    activo TINYINT(1) DEFAULT 1,
    INDEX idx_fecha_creacion (fecha_creacion),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de Protocolos
CREATE TABLE IF NOT EXISTS protocolos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    icono VARCHAR(50) DEFAULT '⚡',
    url VARCHAR(500) NOT NULL,
    fecha_actualizacion VARCHAR(50) DEFAULT 'Ene 2026',
    estado VARCHAR(50) DEFAULT 'Publicado',
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    activo TINYINT(1) DEFAULT 1,
    INDEX idx_fecha_creacion (fecha_creacion),
    INDEX idx_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar datos de ejemplo para Circulares
INSERT INTO circulares (titulo, descripcion, url) VALUES
('Circular 010-A COMISIONES PERSONAL', 'Comunicado sobre comisiones del personal.', 'https://docs.google.com/document/d/e/2PACX-1vQYhshXDJWKRgIq6Od_9Vf-zPfGv7GDApgaVFlWlis6ihfpNdNW9jJZRGIQf4X-Tg/pub'),
('Circular 040-A Costos de Visitas a los clientes por ticket de soporte técnico de campo', 'Comunicado sobre costos de visitas a los clientes por ticket de soporte técnico de campo.', 'https://docs.google.com/document/d/e/ PACX-1vR9QOSQLrIn5L_GxZaXQ1NFWiZ0lsAt0aXG5cwdStRjk81juo2gokZVdMP7huXOBQ/pub'),
('Circular 050-Control de Asistencia, Notificación y Justificación de Faltas', 'Comunicado sobre el control de asistencia, notificación y justificación de faltas.', 'https://docs.google.com/document/d/e/2PACX-1vT9E62QdF_RUMOOG6hXIpTROG6D-FBwiGU8Z7PhdxtxY4TF_We2pjZ9mvLJPN4kBg/pub'),
('Estrategias para la Optimización y Gestión del Técnico de Campo', 'Comunicado sobre estrategias para la optimización y gestión del técnico de campo.', 'https://docs.google.com/document/d/184SHQZjqCsHFaWDD4M5oe54swL_Q-M-Q/edit?usp=drive_link&ouid=111277615836803157702&rtpof=true&sd=true'),
('Circular 000-A Clasificación Técnico Operativo', 'Comunicado sobre clasificación Técnico Operativo.', 'https://docs.google.com/document/d/1OdtA95-vHzy9y-JUeNP8MrGOicp0ozzO/edit?usp=drive_link&ouid=111277615836803157702&rtpof=true&sd=true'),
('PROCEDIMIENTO OBLIGATORIO PARA TRABAJOS EN RESPALDO ELÉCTRICO', 'Comunicado sobre procedimiento obligatorio para trabajos en respaldo eléctrico.', 'https://docs.google.com/document/d/1gAbTqSISCe7yu683tvN3iD3hs1uD3PfX/edit?usp=sharing&ouid=111277615836803157702&rtpof=true&sd=true'),
('CIRCULAR INFORMATIVA: PROTOCOLOS Y PROCEDIMIENTOS PARA INSTALACIÓN DE FIBRA ÓPTICA Y ATENCIÓN DE REPORTES CABLEADOS Y DE FIBRA.', 'Comunicado sobre instalación de fibra óptica y atención de reportes cableados y de fibra.', 'https://docs.google.com/document/d/1wGJItYLNyWImcRwh8RySCZxmnRJs6Ts1/edit?usp=sharing&ouid=111277615836803157702&rtpof=true&sd=true'),
('ORDEN DE PERMANENCIA ESTRICTA EN OFICINAS ASIGNADAS PARA TÉCNICOS DE CAMPO.', 'Comunicado sobre permanencia estricta en oficinas asignadas para técnicos de campo.', 'https://docs.google.com/document/d/1miGWB-arRnpemdmov8A_9br1tyUU0Mwx/edit?usp=sharing&ouid=111277615836803157702&rtpof=true&sd=true');

-- Insertar datos de ejemplo para Funciones
INSERT INTO funciones (titulo, descripcion, url) VALUES
('MANUAL DE FUNCIONES - COORDINADOR TÉCNICO OPERATIVO', 'Documento detallado de funciones y responsabilidades del Coordinador Técnico Operativo.', 'https://docs.google.com/document/d/1dR60cV3TtTNMHlY9fcpdwAhCCDigfWNX/edit?usp=sharing&ouid=111277615836803157702&rtpof=true&sd=true');

-- Insertar datos de ejemplo para Protocolos
INSERT INTO protocolos (titulo, descripcion, icono, url, fecha_actualizacion, estado) VALUES
('Instalación Eléctrica', 'Protocolo técnico para la instalación de puntos eléctricos, medidas de seguridad y estándares de cableado.', '⚡', 'manualfinal.html', 'Ene 2026', 'Publicado'),
('Instalación Batería LiFePO4', 'Protocolo Técnico de Configuración y Seguridad para baterías LiFePO4 y JK BMS.', '🔋', 'manual2.html', 'Ene 2026', 'Publicado'),
('Protocolos de Soporte, Cobro y Optimización de Servicio', 'Protocolo técnico para la instalación y configuración de televisores y soportes.', '🛠', 'manual3.html', 'Feb 2026', 'Publicado');
