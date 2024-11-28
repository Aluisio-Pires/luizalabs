# Conta Corrente - Luizalabs
## Desafio Técnico para desenvolvedor Laravel (backend)

## Resumo do desafio

O projeto consiste no desenvolvimento de um sistema robusto e confiável para a gestão de contas correntes de um banco, com funcionalidades que abrangem desde o registro e controle de dados de contas até o processamento de transações financeiras. Cada conta deve ser devidamente estruturada com atributos essenciais, como número único, saldo atual, data de criação e um histórico detalhado de transações, que incluirá depósitos, saques e transferências. Adicionalmente, o sistema precisa implementar regras de negócio claras, como o respeito a limites de crédito, aplicação automática de taxas em operações financeiras, e garantia de consistência em transferências, que devem ser realizadas de forma atômica para evitar inconsistências entre contas de origem e destino.

Para assegurar a confiabilidade e a escalabilidade, o sistema deve ser projetado para lidar com múltiplas transações simultâneas em uma mesma conta, utilizando mecanismos de sincronização ou bloqueio para evitar conflitos de concorrência. Além disso, será essencial o registro detalhado de todas as transações e mudanças no saldo, permitindo auditorias futuras. O desenvolvimento incluirá também um método para processamento em lote de transações, garantindo que qualquer falha seja devidamente registrada e revertida sem prejuízo à integridade dos dados. Como um desafio adicional, espera-se uma estratégia para recuperação de falhas durante o processamento de transações, de modo a garantir a continuidade do sistema sem perda de dados. O projeto deve ser entregue com código-fonte funcional, acompanhado de testes unitários e de integração que assegurem o cumprimento dos requisitos.

#Considerações Gerais
- Cada conta possui um saldo geral e um limite de crédito fixo. Esse saldo geral pode ser negativo contanto que a soma do saldo com o limite de crédito seja maior ou igual a zero.
- O projeto utiliza um padrão de armazenamento de valores em Microns (feito através de casting) para salvar os valores decimais como inteiros no banco. Salvar os valores como Microns (6 casas decimais) evita problemas de arredondamento e cálculo com valores decimais, além de garantir que taxas de baixa percentagem tenham efeito sobre os valores.
- Foi utilizado o Laravel Jetstream para agilizar o desenvolvimento da autenticação e criação de telas no frontend.
- Foi utilizado o Laravel Reverb para implementar o Websockets responsáveis por notificar os clientes, em tempo real, sobre o andamento das transações.
- A garantia de idempotência foi adicionada aos FormRequests de criação (o método put já é idempotente) por meio de um cache de 15 segundos que verifica esses mesmos dados já foram passados anteriormente.
- Foi utilizado um sistema de ledge, sub-ledge e transações para garantir a integridade dos dados e manter registros de falhas sem alterar os valores das contas.
- Ao criar uma transação é disparado um job para a fila do redis, esse job faz o lock de outros jobs para as contas relacionadas a essas transações, garantindo que transações paralelas não afetem a integridade da transação processada.
- Ao processar uma transação, é utilizado DB::transaction para garantir que todas as alterações no banco sejam feitas, ou retornem ao estado anterior. No caso de falha, a transação recebe um status de falha e não gera alterações nas contas envolvidas.
- Caso a transação ocorra normalmente, é criado um subledger para registrar os dados da transação. Esse subledge é relacionado à transação principal e ao ledger principal que é responsável por registrar se o valor representa uma entrada ou uma saída financeira àquela conta.
- Em transações do tipo transferência são registrados dois subledgers, um para a conta de origem e outro para a conta de destino.
- O sistema de transações funciona em lote, permitindo que as transações sejam processadas simultaneamente e que os dados de cada transação sejam registrados em um subledger separado.
- A auditoria e log é feito por um modelo chamado Trail que é criado em Observers nos modelos de conta e transação.
- O sistema de permissões não foi implementado, pois não fazia parte do escopo solicitado no desafio. Porém as policies foram geradas e estão prontas para receberem o sistema de permissões.
- A cobertura de código foi feita em cima da pasta app/Http e consta 100% de cobertura de testes.
- A documentação da API foi feita usando uma biblioteca própria que transforma a estrutura do Laravel em uma estrutura do Swagger.
- O projeto foi criado usando Laravel Sail para garantir que os ambientes de desenvolvimento e de testes sejam compatíveis, evitando problemas de compatibilidade entre sistemas operacionais e versões de PHP.

## Tecnologias Utilizadas

- [Laravel](https://laravel.com/) - Framework PHP para desenvolvimento web.
- [Vue.js](https://vuejs.org/) - Framework de desenvolvimento JavaScript.
- [Inertia.js](https://inertiajs.com/) - Conector entre Vue.js e Laravel.
- [Laravel Jetstream](https://jetstream.laravel.com/) - Framework de autenticação e autorização para Laravel.
- [Tailwind CSS](https://tailwindcss.com/) - Framework de estilos CSS.
- [PostgreSQL](https://www.postgresql.org/) - Sistema de gerenciamento de banco de dados relacional.
- [Redis](https://redis.io/) - Sistema de gerenciamento de banco de dados in-memory de alta performance.
- [Laravel Reverb](https://reverb.laravel.com/) - Websocket para o Laravel.
- [Laravel Sail](https://laravel.com/docs/sail) - Ambiente de desenvolvimento Docker para Laravel.
- [Pest](https://pestphp.com/) - Framework de testes unitários para PHP.
- [Laravel Pint](https://laravel.com/docs/pint) - Ferramenta de formatação de código para o Laravel.
- [Larastan](https://larastan.org/) - Ferramenta de qualidade de código para o Laravel basada no PHPStan.
- [Rector](https://github.com/rectorphp/rector) - Ferramenta de reescrita de código PHP.
- [Swagger](https://swagger.io/) - Documentação para APIs.
- [Docker](https://www.docker.com/) - Plataforma para desenvolvimento, envio e execução de aplicações em contêineres.
- [Composer](https://getcomposer.org/) - Gerenciador de dependências para PHP.
- [Node.js & NPM](https://nodejs.org/) - Para gerenciamento de pacotes JavaScript e compilação de assets.
- [Git](https://git-scm.com/) - Sistema de controle de versões distribuído.
- [GitHub](https://github.com/) - Plataforma de hospedagem de repositórios de código-fonte.
- [WSL](https://docs.microsoft.com/pt-br/windows/wsl/) - Sistema de desenvolvimento Linux integrado para Windows.

## Pré-requisitos

Antes de começar, você precisará ter instalado em sua máquina:

- [Docker](https://docs.docker.com/get-docker/)
- [Composer](https://getcomposer.org/download/)
- [Node.js e NPM](https://nodejs.org/en/download/)

## Instalação

Siga os passos abaixo para configurar o projeto localmente.

### 1. Clone o repositório

```bash
git clone git@github.com:Aluisio-Pires/luizalabs.git
cd luizalabs
```

### 2. copie o arquivo .env.example para .env

```bash
cp .env.example .env
```

### 3. Instale as dependências do composer

```bash
composer install
```

### 4. Instale as dependências do npm

```bash
npm install
npm run build
```

### 5. Monte o ambiente de desenvolvimento

```bash
./vendor/bin/sail build
./vendor/bin/sail up -d
```

### 6. Execute os comandos para gerar a key e o link com o storage

```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan storage:link
```

### 7. Execute o comando de migração do banco de dados

```bash
./vendor/bin/sail artisan migrate
```

### 8. Iniciar o servidor de websockets

```bash
./vendor/bin/sail artisan reverb:start --debug
```

### 9. Abra um novo terminal e inicie as filas com o redis

```bash
./vendor/bin/sail artisan queue:listen redis
```

### 10. O Swagger pode ser acessado em 
http://127.0.0.1:9000/documentation

### (Opcional) Crie um alias para o sail
#### Para o Bash
```bash
echo "alias sail='./vendor/bin/sail'" >> ~/.bashrc && source ~/.bashrc
```

#### Para o Zsh
```bash
echo "alias sail='./vendor/bin/sail'" >> ~/.zshrc && source ~/.zshrc
```

## Considerações Finais

- Apesar de ser um teste focado no backend, foi possível por em prática o conhecimento em frontend em estruturas como Paginação Infinita e Websockets.
- Apesar de simples, o desafio técnico abrange um conhecimento denso do ecossistema Laravel, permitindo exibir e testar as habilidades necessárias para o desenvolvimento de uma API robusta.

## Desafio Adicional

### Recuperação de Falhas
A contenção de falhas foi bem abordada durante o desenvolvimento do projeto. O processamento por filas dando um feedback visual ao usuário permite que o mesmo consiga lidar em caso de falhas inesperadas. Além disso, todas as movimentações são registradas em log, o que facilita a atuação em cima de eventuais erros que possam atrapalhar o bom funcionamento do sistema.
Vale lembrar, que caso alguma transação essencial falhe, ocorre rollback nos registros afetados, não causando transtorno financeiro ao usuário, essa abordagem permite que o próprio usuário consiga tentar realizar a transação novamente e lidar com o problema.
