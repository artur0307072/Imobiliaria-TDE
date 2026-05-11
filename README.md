# Imobiliaria-TDE
Sistema web desenvolvido em PHP e MySQL para gerenciamento de imóveis, permitindo cadastro de usuários, autenticação e controle de imóveis cadastrados.

Tecnologias Utilizadas

* PHP
* MySQL
* HTML5
* CSS3
* PDO
* Sessões PHP
  
Relacionamento

* Um usuário pode cadastrar vários imóveis.
* Cada imóvel pertence a apenas um usuário.

Como Executar o Projeto

1. Clonar o repositório

git clone https://github.com/seu-usuario/seu-repositorio.git

2. Configurar o ambiente

Mover o projeto para a pasta do servidor local:

* XAMPP → htdocs

3. Criar o banco de dados

No MySQL/phpMyAdmin:

CREATE DATABASE imobiliaria;

Importe o arquivo:

banco.sql

4. Configurar conexão

Editar o arquivo:

config/conexao.php

Exemplo:

$host = "localhost";
$db = "imobiliaria";
$user = "root";
$pass = "";

5. Executar o projeto

Acessar no navegador:

http://localhost/imobiliaria
