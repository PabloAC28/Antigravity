-- database.sql
-- Datos de prueba y esquema inicial para la base de datos de Antigravity

CREATE TABLE IF NOT EXISTS marcas (
    id_marca INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS componentes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    id_marca INT NOT NULL,
    FOREIGN KEY (id_marca) REFERENCES marcas(id_marca)
);

-- Insertar marcas por defecto
INSERT INTO marcas (nombre) VALUES ('Asus'), ('MSI'), ('Corsair'), ('Gigabyte'), ('EVGA');

-- Insertar algunos componentes de prueba
INSERT INTO componentes (nombre, precio, stock, id_marca) VALUES 
('RTX 4090', 1599.99, 5, 2),
('ROG Strix B650', 219.50, 12, 1),
('Vengeance RGB 32GB', 110.00, 30, 3);
