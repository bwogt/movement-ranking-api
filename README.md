# 🏋️ Movement Ranking API
API REST em PHP para cálculo de ranking de movimentos com base em recordes pessoais de usuários.

## 📄 Case Técnico 
https://drive.google.com/file/d/1H4gin62SGw1XCWJt7j0FQHLRKRyTLvIs/view

## 🎯 Sobre o Projeto

Este projeto implementa um endpoint que retorna o ranking de usuários para um determinado movimento, considerando:
- Maior recorde pessoal por usuário
- Ordenação decrescente por valor e nome do usuário
- Empate de posições quando valores são iguais

## 🚀 Tecnologias
+ PHP 
+ MySQL 
+ Docker & Docker Compose
+ FastRoute (Routing)
+ Composer (Gerenciamento de dependências)
+ PDO (Abstração de banco de dados)
+ PHPUnit (Testes unitários e de integração)

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

5. Instale as dependências (Composer):
~~~bash
docker compose exec app composer install
~~~

🌐 Endpoint disponível
~~~bash
GET /api/movement/{movement}/ranking

Exemplos:
/api/movement/1/ranking
/api/movement/Deadlift/ranking
/api/movement/Bench%20Press/ranking

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

## 🧠 Decisões técnicas
- Foi utilizada uma abordagem de Clean Architecture leve, separando responsabilidades em camadas bem definidas;
- O roteamento foi implementado com `FastRoute`, priorizando simplicidade e performance sem introduzir frameworks completos;
- A resolução de Movement a partir da URL foi abstraída em um MovementResolver, evitando lógica no controller;
- O endpoint aceita tanto `ID` quanto `nome` do movimento, permitindo maior flexibilidade de consumo da API;
- Foi utilizada a camada de Use Cases para encapsular regras de negócio, evitando o acoplamento de lógica no controller e prevenindo `god classes`;
- O projeto foi containerizado com Docker, garantindo um ambiente totalmente reproduzível para desenvolvimento e testes, independentemente da máquina ou configuração local;
- A separação de serviços (PHP-FPM, Nginx e MySQL) foi adotada para simular uma arquitetura próxima de produção, facilitando escalabilidade e isolamento de responsabilidades;
- O uso de ambientes separados para desenvolvimento e testes (.env e .env.testing) garante isolamento e confiabilidade na execução dos testes automatizados;

## 🔄 Possíveis melhorias futuras
- Adicionar um fluxo de CI com GitHub Actions para executar testes unitários e de integração automaticamente;
- Adicionar lint para PHP para garantir padronização, formatação e qualidade de código;
- Adicionar paginação no endpoint de ranking para suportar grandes volumes de dados e melhorar performance e consumo da API; 
- Implementar versionamento da API (/api/v1/...) para permitir evolução sem quebra de contratos;
- Evoluir o sistema de rotas para facilitar a organização das rotas, permitindo melhor separação entre definição de endpoints e execução de dependências;
- Criar um sistema de factories para testes, evitando dependência de seeds fixas e garantindo maior isolamento, previsibilidade e facilidade na criação de cenários de teste.
