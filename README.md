# PROJETO Ordens de Serviço

## Versões utilizadas para o desenvolvimento
- Apache 2.4.62
- PHP 8.3.14
- MySQL  8.3.14

## Softwares obrigatórios
- PHP: https://www.php.net/
- MySQL : https://dev.mysql.com/community/

# Instalação

## Clonar o PROJETO do seguinte repositótio: https://github.com/andreyrff-git/tc_ordem.git
- git clone https://github.com/andreyrff-git/tc_ordem.git

## Etapas preparatórias
- Instale o composer no servidor apache
- Caso a instalação seja no windows, nas variáveis de ambiente do windos, na variável "PATH", inclua um novo caminho indicando a pasta onde se encontra o bat do composer, arquivo composer.bat
- Abra o prompt e acesse a pasta base do seu projeto e execute o comando "composer require firebase/php-jwt" para instalação da biblioteca JWT

## Configurar o acesso ao banco de dados
- No PROJETO, acesse o diretório config e edite o arquivo config.php informando o NOMEDOBANCO, o USUARIO e a SENHA
```
return [
  'db_host'=>'localhost',
  'db_name'=>'ordemservico',
  'db_user'=>'admin',
  'db_pass'=>'admin@123',
  'jwt_secret'=>'SECRETO123',
  'jwt_exp'=>3600
];
```

## Criar o banco de dados com o NOMEDOBANCO, USUARIO com todos os privilégios e informar a SENHA
```
CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin@123';

CREATE DATABASE IF NOT EXISTS ordemservico CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ordemservico;

GRANT ALL PRIVILEGES ON ordemservico.* TO 'admin'@'localhost';

FLUSH PRIVILEGES;
```

## Criar a estrutura do banco de dados e importar 
O arquivos para criação do banco e importação do usuário para login, encontra-se no diretorio principal dp PROJETO.
- Arquivo para criação da estrutura: script_database.sql 

## Para executar o projeto Ordens de Serviço
- Acesse o diretório onde o Ordens de Serviço foi clonado
- Na raiz do projeto, execute o comando `php -S localhost:8000`
- Execute um browser de sua preferência e informe na barra de endereços http://localhost:8000 ou http://localhost/index.php
- Crie um novo Virtual Host chamado "ordemservico"
- Acesse então a url http://ordemservico/public/index.php
- O LOGIN e a SENHA são respectivamente: teste@teste.com e user@123 
- Se caso você possuir o servidor web Apache, copie todos os arquivos do projeto para o diretório root e acesse com o endereço de acordo com sua configuração, geralmente http://localhost


