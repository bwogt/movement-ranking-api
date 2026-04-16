# 🏋️ Movement Ranking API
API REST em PHP para cálculo de ranking de movimentos com base em recordes pessoais de usuários.

## 📄 Case Técnico 
https://drive.google.com/file/d/1H4gin62SGw1XCWJt7j0FQHLRKRyTLvIs/view

## 🧠 Descrição

Este projeto implementa um endpoint que retorna o ranking de usuários para um determinado movimento, considerando:

- Maior recorde pessoal por usuário
- Ordenação decrescente por valor
- Empate de posições quando valores são iguais

## 🛠️ Tecnologias
+ PHP 
+ MySQL 
+ Docker & Docker Compose
+ PHPUnit
+ FastRoute (routing leve, sem framework)

## 🐳 Ambiente de Desenvolvimento (Docker)

**Requisitos**
 - Docker Engine
 - Docker Compose

### Passos para executar

1. Clone o Repositório
~~~git
git@github.com:bwogt/movement-ranking-api.git
~~~

2. Acesse a Pasta do Projeto
~~~bash
cd movement-ranking-api
~~~

3. Copie o arquivo de ambiente
~~~bash
cp .env.example .env
~~~

4. Suba o ambient web
~~~bash
docker compose --profile web up -d --build
~~~

🌐 Endpoint disponível
~~~bash
GET /api/movement/{movement}/ranking

Exemplos:
/api/movement/1/ranking
/api/movement/Deadlift/ranking

~~~

## 🧪 Ambiente de Testes
O ambiente de testes é isolado e utiliza:
 - Containers próprios
 - Banco de dados dedicado
 - Variáveis de ambiente específicas

1 . Subir ambiente de testes
~~~bash
docker compose --profile test --env-file=.env.testing up -d --build
~~~

2 . Executar testes
~~~bash
docker compose exec app ./vendor/bin/phpunit
~~~

## 📌 Regras de negócio implementadas
- Usuários com maior recorde pessoal são ranqueados em ordem decrescente;
- Empates recebem a mesma posição;
- O ranking é calculado dinamicamente via Use Case

## 🧱 Arquitetura

O projeto segue princípios de Clean Architecture:

- Domain (regras de negócio)
- Application (use cases)
- Infrastructure (PDO / MySQL)
- HTTP Layer (controllers + resolvers)
