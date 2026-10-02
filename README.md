# Sistema de Controle de Chamados

Aplicação web para gerenciamento de chamados internos, desenvolvida como desafio técnico para avaliação Full Stack.

O sistema permite cadastrar, visualizar, editar e excluir chamados, acompanhar seus status e prioridades e atribuir responsáveis manualmente ou de forma automática, buscando equilibrar a distribuição dos chamados entre a equipe.

## Funcionalidades

- Cadastro de chamados
- Listagem de chamados
- Visualização detalhada de chamados
- Edição de chamados
- Exclusão de chamados
- Definição de prioridade
- Controle de status
- Seleção manual de responsável
- Atribuição automática de responsável
- Filtros por status, prioridade e responsável
- Ordenação dos chamados pela data de abertura
- Validação dos dados de entrada
- Testes automatizados
- Pipeline de integração contínua com GitHub Actions

## Requisitos atendidos

A aplicação contempla os requisitos principais propostos no desafio.

### Chamados

Cada chamado possui:

- Título
- Descrição
- Prioridade
- Status
- Responsável
- Data e hora de abertura

O sistema permite:

- Criar chamados
- Listar chamados
- Visualizar chamados
- Editar chamados
- Excluir chamados

### Responsáveis

A aplicação possui responsáveis previamente cadastrados através de seeders.

Foram disponibilizados inicialmente:

- Ana Silva
- Carlos Oliveira
- Mariana Costa

Não foi criada uma tela específica para gerenciamento dos responsáveis, pois esse cadastro não faz parte do escopo solicitado.

### Distribuição automática

Ao criar um chamado, o usuário pode:

- selecionar manualmente um responsável; ou
- deixar a opção "Automático" selecionada.

Quando a atribuição automática é utilizada, o sistema seleciona o responsável que possui a menor quantidade de chamados considerados em aberto.

Em caso de empate, o sistema utiliza o menor `id` do responsável como critério de desempate. Isso mantém o comportamento determinístico e evita que a escolha dependa de uma ordenação indefinida.

### Definição de chamado "em aberto"

Para fins de distribuição automática, são considerados em aberto os chamados com os seguintes status:

- `Aberto`
- `Em andamento`

Chamados com status `Concluído` não entram na contagem.

A decisão foi tomada considerando que um chamado em andamento ainda representa trabalho ativo para o responsável, enquanto um chamado concluído não representa mais carga de trabalho pendente.

## Tecnologias utilizadas

### Backend

- PHP 8.5
- Laravel 13
- SQLite

### Frontend

- Vue.js
- Inertia.js
- Tailwind CSS
- Vite

### Qualidade e desenvolvimento

- PHPUnit/Pest através da estrutura de testes do Laravel
- Git
- GitHub
- GitHub Actions

## Justificativa das escolhas tecnológicas

### Laravel

O Laravel foi escolhido para o backend por fornecer uma estrutura organizada para desenvolvimento de aplicações web, incluindo:

- roteamento;
- controllers;
- validação através de Form Requests;
- migrations;
- Eloquent ORM;
- seeders;
- suporte a testes;
- integração simples com diferentes bancos de dados.

A escolha também facilita a manutenção por uma equipe pequena, mantendo responsabilidades bem separadas.

### Inertia.js + Vue.js

Foi utilizada uma arquitetura baseada em Inertia.js e Vue.js para evitar a necessidade de criar uma API REST separada para uma aplicação desse porte.

O Laravel continua responsável pelas rotas, regras de negócio e acesso aos dados, enquanto o Vue.js fica responsável pela interface.

Essa abordagem reduz a quantidade de código necessário para conectar frontend e backend e diminui o atrito de desenvolvimento para uma aplicação pequena.

### Tailwind CSS

O Tailwind CSS foi utilizado para construção da interface.

A escolha permite desenvolver uma interface organizada e responsiva sem a necessidade de criar uma grande quantidade de CSS próprio.

### SQLite

SQLite foi escolhido como banco de dados para facilitar a execução local do projeto.

Como o objetivo do desafio é entregar uma aplicação pequena e facilmente executável pela equipe, o SQLite elimina a necessidade de configurar e manter um servidor de banco de dados durante a avaliação.

A estrutura de banco continua sendo definida através de migrations, permitindo substituir o banco posteriormente com poucas alterações.

## Arquitetura

A aplicação utiliza uma organização baseada nas responsabilidades de cada camada.

De forma simplificada:

    Vue.js
       |
       v
    Inertia.js
       |
       v
    Rotas
       |
       v
    Controllers
       |
       +---- Form Requests
       |
       +---- Services
       |
       v
    Models / Eloquent
       |
       v
    SQLite

### Controllers

Os controllers são responsáveis pelo fluxo das requisições e pela comunicação entre as diferentes partes da aplicação.

### Form Requests

As validações de criação e atualização dos chamados foram separadas em Form Requests:

- `StoreChamadoRequest`
- `UpdateChamadoRequest`

Isso mantém as regras de validação fora do controller e facilita sua manutenção.

### Service

A regra de atribuição automática foi isolada no:

`AtribuicaoChamadoService`

Essa separação evita colocar uma regra de negócio importante diretamente no controller e permite testá-la de forma independente.

### Models

Os models representam as entidades persistidas no banco:

- `Chamado`
- `Responsavel`

O relacionamento entre eles é:

`Responsavel hasMany Chamados`

`Chamado belongsTo Responsavel`

### Enums

Foram utilizados enums para representar os valores permitidos de prioridade e status:

- `PrioridadeChamado`
- `StatusChamado`

Isso evita espalhar strings de status e prioridade pela aplicação e deixa o domínio mais explícito.

## Estrutura principal

```text
app/
├── Http/
│   ├── Controllers/
│   │   └── ChamadoController.php
│   └── Requests/
│       ├── StoreChamadoRequest.php
│       └── UpdateChamadoRequest.php
│
├── Models/
│   ├── Chamado.php
│   └── Responsavel.php
│
├── Services/
│   └── AtribuicaoChamadoService.php
│
├── PrioridadeChamado.php
└── StatusChamado.php

database/
├── migrations/
└── seeders/

resources/
└── js/
    └── pages/
        └── Chamados/
            ├── Index.vue
            ├── Create.vue
            ├── Edit.vue
            └── Show.vue

routes/
└── web.php

tests/
└── Feature/
    ├── AtribuicaoChamadoServiceTest.php
    └── ChamadoControllerTest.php

.github/
└── workflows/
    └── tests.yml
```

## Requisitos para execução

Antes de executar o projeto, certifique-se de possuir instalado:

- PHP 8.5 ou compatível
- Composer
- Node.js 22 ou compatível
- npm
- Git

## Instalação

Clone o repositório:

```bash
git clone <URL_DO_REPOSITORIO>
```

Entre na pasta do projeto:

```bash
cd sistema-chamados
```

Instale as dependências do PHP:

```bash
composer install
```

Instale as dependências do frontend:

```bash
npm install
```

## Configuração do ambiente

Copie o arquivo de ambiente:

### Linux/macOS

```bash
cp .env.example .env
```

### Windows PowerShell

```powershell
Copy-Item .env.example .env
```

Gere a chave da aplicação:

```bash
php artisan key:generate
```

## Banco de dados

O projeto utiliza SQLite.

Caso o arquivo do banco ainda não exista, crie:

### Linux/macOS

```bash
touch database/database.sqlite
```

### Windows PowerShell

```powershell
New-Item database/database.sqlite -ItemType File
```

Depois execute as migrations e o seed:

```bash
php artisan migrate --seed
```

O seed cria os responsáveis necessários para utilização da aplicação.

Se for necessário recriar completamente o banco durante o desenvolvimento:

```bash
php artisan migrate:fresh --seed
```

> **Atenção:** `migrate:fresh` remove as tabelas existentes e recria o banco.

## Executando a aplicação

A aplicação possui dois processos durante o desenvolvimento.

### Terminal 1 - Laravel

```bash
php artisan serve
```

Por padrão, a aplicação estará disponível em:

```text
http://127.0.0.1:8000
```

### Terminal 2 - Vite

```bash
npm run dev
```

Com os dois processos executando, acesse:

```text
http://127.0.0.1:8000/chamados
```

## Executando os testes

Para executar a suíte de testes:

```bash
php artisan test
```

Os testes cobrem principalmente as regras de negócio e os fluxos principais da aplicação.

Entre os cenários testados estão:

- Criação de chamado com responsável informado
- Atribuição automática de responsável
- Seleção do responsável com menor quantidade de chamados em aberto
- Desconsideração de chamados concluídos na distribuição
- Desempate entre responsáveis
- Visualização de chamado
- Edição de chamado
- Exclusão de chamado
- Validação de campos obrigatórios

## Integração contínua

O projeto possui um workflow de GitHub Actions em:

```text
.github/workflows/tests.yml
```

A cada `push` ou `pull request` para as branches principais, o workflow executa:

1. Checkout do código
2. Configuração do PHP
3. Instalação das dependências PHP
4. Configuração do SQLite
5. Execução das migrations
6. Configuração do Node.js
7. Instalação das dependências frontend
8. Build do frontend
9. Execução dos testes automatizados

O objetivo é detectar problemas de integração antes que alterações sejam consideradas prontas.

## Decisões e trade-offs

### SQLite em vez de MySQL/PostgreSQL

Para este desafio, foi priorizada a facilidade de execução local.

A utilização de SQLite reduz a quantidade de dependências externas necessárias para executar o projeto.

Caso a aplicação evolua para um ambiente de produção, o banco poderá ser substituído por uma solução como PostgreSQL ou MySQL.

### Sem autenticação

Autenticação e autorização não foram implementadas porque não fazem parte dos requisitos do desafio.

A implementação foi mantida focada no fluxo principal de gerenciamento dos chamados.

### Responsáveis via Seeder

Não foi criada uma interface de cadastro de responsáveis porque o próprio escopo informa que não é necessário um cadastro completo.

Os responsáveis são criados através do seeder e podem ser selecionados na criação ou edição dos chamados.

### Sem API REST separada

Foi utilizada a integração Laravel + Inertia.js + Vue.js.

Para o tamanho atual da aplicação, criar uma API REST separada adicionaria complexidade sem um benefício proporcional.

A arquitetura pode ser expandida futuramente caso surja a necessidade de atender outros clientes, como aplicações mobile ou integrações externas.

### Sem paginação

A listagem atual trabalha com o volume esperado para o escopo do desafio.

Caso a quantidade de chamados cresça significativamente, a listagem poderá ser alterada para paginação e busca no banco.

### Containerização

Docker não foi incluído na entrega atual para evitar adicionar complexidade à configuração de uma aplicação que pode ser executada diretamente com PHP, Node.js e SQLite.

Como evolução futura, a aplicação poderá ser containerizada com Docker, buscando padronizar o ambiente de execução e reduzir diferenças entre desenvolvimento, homologação e produção.

## Princípios utilizados

Durante a implementação foram considerados alguns princípios de organização.

### Separação de responsabilidades

Regras de validação foram mantidas nos Form Requests e a lógica de distribuição automática foi isolada em um Service.

### DRY

Regras e responsabilidades foram centralizadas para evitar duplicação desnecessária de código.

### SOLID

A aplicação procura manter responsabilidades bem definidas, principalmente através da separação entre controllers, requests, models e services.

### Pragmatismo

A solução foi mantida proporcional ao escopo do desafio.

A prioridade foi entregar os requisitos principais com código organizado e testado, evitando adicionar funcionalidades que não contribuem diretamente para o problema proposto.

## Referências e bibliotecas externas

Foram utilizadas as documentações oficiais das tecnologias adotadas como referência durante o desenvolvimento:

- Laravel
- Inertia.js
- Vue.js
- Tailwind CSS
- Vite
- GitHub Actions
- Pest/PHPUnit

Nenhuma biblioteca externa adicional foi utilizada para implementar a regra de distribuição automática dos chamados.

## Possíveis evoluções

Caso o projeto continue evoluindo, algumas melhorias possíveis seriam:

- Autenticação e autorização
- Cadastro e gerenciamento de responsáveis
- Paginação da listagem
- Busca por título e descrição
- Histórico de alterações dos chamados
- Notificações
- Dashboard com indicadores
- API para integrações externas
- Banco PostgreSQL ou MySQL em produção
- Containerização com Docker
- Deploy automatizado
- Maior cobertura de testes de interface e integração

## Status do projeto

Projeto desenvolvido como desafio técnico Full Stack.

Principais fluxos implementados e testados:

- CRUD de chamados
- Distribuição automática
- Distribuição manual
- Filtros
- Validações
- Testes automatizados
- Build frontend
- Integração contínua