-- USUARIOS
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    dtcadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
     constraint pk_usuario primary key(id) 
);

-- CLIENTES
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    documento VARCHAR(14),
    logradouro VARCHAR(60), 
    numero VARCHAR(10), 
    complemento VARCHAR(20), 
    bairro VARCHAR(60), 
    cidade VARCHAR(60), 
    uf VARCHAR(2), 
    cep VARCHAR(9),
    dtcadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    constraint pk_cliente primary key(id) 
);

-- PRODUTOS
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT,
    descricao VARCHAR(100) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    dtgarantia DATETIME,
    ativo CHAR(1) DEFAULT 'T',
    constraint pk_produto primary key(id) 
);

-- ORDEM DE SERVIÇO
CREATE TABLE IF NOT EXISTS ordens (
    id_ordem INT AUTO_INCREMENT,
    cliente_id INT NOT NULL,
    produto_id INT NOT NULL,
    descricao TEXT,
    dtabertura DATETIME DEFAULT CURRENT_TIMESTAMP,
    constraint pk_ordem primary key(id_ordem),
    constraint fk_ordem_cliente FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    constraint produto FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE,
    constraint fk_ordem_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
);

INSERT INTO usuarios(email,senha) values ('teste@teste.com', 'user@123');