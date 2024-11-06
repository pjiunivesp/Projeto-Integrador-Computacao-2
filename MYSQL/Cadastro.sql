CREATE DATABASE adestramento;

USE adestramento;

CREATE TABLE IF NOT EXISTS tutores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    endereco VARCHAR(255) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    autorizacao_imagem ENUM('sim', 'nao') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS caes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tutor_id INT NOT NULL,
    nome_aluno VARCHAR(255) NOT NULL,
    raca VARCHAR(100) NOT NULL,
    idade INT NOT NULL,
    sexo ENUM('masculino', 'feminino') NOT NULL,
    castrado ENUM('sim', 'nao') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tutor_id) REFERENCES tutores(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    cachorro_nome VARCHAR(100) NOT NULL,
    motivo_contato VARCHAR(100) NOT NULL,	
    data DATE NOT NULL,
    horario TIME NOT NULL,
    status ENUM('pendente', 'confirmado', 'atendido', 'cancelado') DEFAULT 'pendente'
);
