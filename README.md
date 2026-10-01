# Help Desk PHP

Sistema de chamados de suporte (CRUD) com login, feito com PHP, MySQL e Docker.

![Tela do sistema](docs/tela-sistema.png)

## Funcionalidades

- Abrir chamados (título e descrição)
- Listar chamados
- Alterar o status: aberto, em andamento, fechado
- Excluir chamados
- Login com usuário e senha, com logout e páginas protegidas por sessão

## Tecnologias

- PHP 8.3 (Apache) com PDO
- MySQL 8.4
- Docker e Docker Compose

## Boas práticas aplicadas

- Consultas com prepared statements (proteção contra SQL injection)
- Saída escapada com `htmlspecialchars` (proteção contra XSS)
- Credenciais fora do código, em arquivo `.env` (não versionado)
- Login com senhas protegidas por `password_hash` e sessões com cookie `HttpOnly`
- Tabela criada automaticamente por `db/init.sql`

## Como rodar

1. Clone o repositório e entre na pasta:

       git clone https://github.com/angelommorozini/helpdesk-php.git
       cd helpdesk-php

2. Crie o arquivo `.env` a partir do exemplo e troque as senhas:

       cp .env.example .env

3. Suba os containers:

       docker compose up -d --build

4. Crie o usuário administrador (o script pede a senha):

       docker compose exec web php /scripts/criar_usuario.php admin

5. Abra no navegador `http://localhost:8080` e entre com esse usuário

## Estrutura

    .
    ├── Dockerfile
    ├── docker-compose.yml
    ├── .env.example
    ├── db/init.sql
    ├── scripts/criar_usuario.php
    └── src/
        ├── auth.php
        ├── db.php
        ├── index.php
        ├── login.php
        ├── logout.php
        └── style.css
