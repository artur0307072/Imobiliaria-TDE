
CREATE DATABASE IF NOT EXISTS imobiliaria
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE imobiliaria;

CREATE TABLE IF NOT EXISTS usuarios (
    id      INT AUTO_INCREMENT PRIMARY KEY,
    nome    VARCHAR(100)  NOT NULL,
    email   VARCHAR(150)  NOT NULL UNIQUE,
    senha   VARCHAR(255)  NOT NULL,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS imoveis (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    titulo    VARCHAR(150)   NOT NULL,
    descricao TEXT,
    preco     DECIMAL(12,2)  NOT NULL,
    endereco  VARCHAR(255)   NOT NULL,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO usuarios (nome, email, senha) VALUES
('Administrador', 'admin@imobiliaria.com',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO imoveis (titulo, descricao, preco, endereco) VALUES
('Apartamento Centro', 'Lindo apartamento de 2 quartos no centro da cidade, com varanda e garagem.', 350000.00, 'Rua das Flores, 123 - Centro'),
('Casa Jardim América', 'Casa espaçosa com 3 quartos, quintal amplo e churrasqueira.', 520000.00, 'Av. Brasil, 456 - Jardim América'),
('Kitnet Universitária', 'Kitnet mobiliada próxima à universidade, ideal para estudantes.', 95000.00, 'Rua Prof. Silva, 78 - Vila Nova');
