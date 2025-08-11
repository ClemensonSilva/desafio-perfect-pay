
# 🚀 Desafio Perfect-Pay  

Implementação do desafio proposto pela empresa **Perfect-Pay**.  

---

## 📌 Descrição  

Este projeto consiste em um aplicativo para **gerenciamento de vendas**, permitindo ao usuário cadastrar e gerenciar informações de **Clientes, Produtos e Vendas** realizadas no negócio.  

Foi desenvolvido seguindo o **padrão MVC (Model-View-Controller)**, garantindo uma arquitetura organizada e modular. Além disso, foram implementadas camadas adicionais para separar responsabilidades:  

- **Layer de Validação**: Garante que os dados recebidos atendam às regras de negócio.  
- **Layer de Repositório**: Responsável pelo acesso ao banco de dados, desacoplando a lógica da aplicação.  
- **Layer de Serviço**: Contém a lógica de negócio, facilitando a reutilização e manutenção do código.  

Essa abordagem melhora a escalabilidade e a testabilidade do sistema.  

---

## 🛠️ Funcionalidades  

- **CRUD Produtos**: Operações básicas para gerenciamento de produtos.  
- **CRUD Clientes**: Operações básicas para gerenciamento de clientes.  
- **CRUD Vendas**: Operações básicas para gerenciamento de vendas. *(Em breve, serão adicionadas validações para garantir a lógica de negócio.)*  
- **Autenticação e Controle de Acesso**:  
  - **Admins**: Possuem acesso total ao sistema e podem realizar todas as operações.  
  - **Vendedores**: Podem apenas adicionar novos produtos, clientes e vendas.  
- **Live Search**: Pesquisa dinâmica de registros sem necessidade de recarregar a página.  
- **Filtro de Data**: Permite que o admin busque vendas realizadas dentro de um período específico.  
- **Dashboard de Análise de Vendas**:  
  - Exibe um panorama das vendas realizadas.  
  - Permite verificar se um determinado período foi de **lucro** para a empresa ou se houve **perdas** (vendas canceladas, devolvidas).  

---

## 📌 Pré-requisitos  

Para rodar este projeto em sua máquina, é necessário ter instalado:  

- **Docker**  

---

## ⚙️ Instalação  

1. Clone o repositório e acesse a pasta do projeto.  
2. Execute os seguintes comandos:  

```
docker compose build
docker compose up
```

e o comando
```
docker compose exec php bash

```

para ter acesso ao container php criado.

- Configurar o .env.example e docker-compose.yml mudando para a conexão com db de sua escolha.

- Dentro do container, rode os comandos:

```
cp .env.example .env
```

```
composer install
```

```
php artisan key:generate
```

- Crie as tabelas com migrations:

```
 php artisan migrate
```

- Criar alguns dados falsos para testes utilizando o comando

```
php artisan db:seed
```

- Por fim, basta rodar o comando ir até localhost:8088 e usar a aplicação.

##



## ⚙️ Executando os testes

- Em desenvolvimento...

###  Analise os testes de ponta a ponta

- Como já foi dito, execulte o comando

```
php artisan db:seed
```
para criar alguns dados falsos a fim de testar a aplicação localmente com alguns dados criados pelo Faker PHP.

##  Construído com

Ferramentas utilizadas no projeto

* [PHP](https://www.php.net/) - Linguagem de programção
* [MySql](https://www.mysql.com/) - Banco de Dados
* [Laravel](https://laravel.com/) - O framework web usado
* [Docker](https://www.docker.com/) - Configuração do ambiente de desenvolvimento
* [Composer](https://getcomposer.or) - Gerente de Dependências
* [Faker PHP](https://fakerphp.org/) - Gerador de dados falsos
