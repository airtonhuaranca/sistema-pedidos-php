CREATE DATABASE IF NOT EXISTS sistema_pedidos CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE sistema_pedidos;

CREATE TABLE IF NOT EXISTS pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    cliente VARCHAR(100) NOT NULL,
    producto VARCHAR(100) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    cantidad INT NOT NULL,
    estado VARCHAR(30) NOT NULL DEFAULT 'Pendiente',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO pedidos (cliente, producto, precio, cantidad, estado) VALUES
('Juan Pérez', 'TECLADO', 20.00, 2, 'Pendiente'),
('María López', 'MOUSE', 30.00, 1, 'Entregado');
