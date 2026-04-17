CREATE DATABASE IF NOT EXISTS taskflow_db;
USE taskflow_db;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS tarefas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descricao TEXT,
    data_prazo DATE,
    status ENUM('PENDENTE','EM_ANDAMENTO','CONCLUIDA') DEFAULT 'PENDENTE',
    id_usuario INT NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS tarefas_compartilhadas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_tarefa INT NOT NULL,
    id_usuario_destino INT NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_tarefa) REFERENCES tarefas(id) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario_destino) REFERENCES usuarios(id) ON DELETE CASCADE,
    UNIQUE (id_tarefa, id_usuario_destino)
);