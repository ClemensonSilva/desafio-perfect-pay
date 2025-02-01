# Desafio Perfect-Pay

Implementação do desafio proposto pela empresa Perfect-pay

## Descrição

Este projeto em forma de desafio consiste em um aplicativo para gerenciamento de vendas. Ele permite ao usuário cadastrar informações de Clientes, Produtos e Vendas feitas em seu negócio. 

## Funcionalidades 

- `CRUD Produtos`: Operações básicas para a tabela produto. 
- `CRUD Clientes`: Operações básicas para a tabela clientes.
- `CRUD Vendas`: Operações básicas para a tabela vendas. Em breve será colocada algumas validações para garantir a lógica de negócio das vendas.
- `Autenticação e histórico de opeações`: Em breve irá ser criado uma funcionalidade que permita que vários usuários tenham acesso ao aplicativo e que suas atividades sejam mapeadas e salvas para futuras consultas.

### Pré-requisitos
- Para rodar esse projeto em sua máquina, você precisar ter instalado:

```
PHP versão > 8.2
Composer
```

###  Instalação

- Instalar o php versão > 8.2;
- Instalar o gerenciador de pacotes Composer;
- Instalar Wamp ou Xamp para ambiente de desenvolvimento completo com Mysql, Apache e PHP;
- Rodar o comando

``` 
composer install
```

- Rodar os comandos no terminal da  pasta 

no windows

``` 
copy .env.example .env
```
no linux 

``` 
cp .env.example .env
```

``` 
php artisan key:generate
``` 

- Configurar o .env mudando para a conexão com db de sua escolha e rode o comando

``` 
 php artisan migrate
``` 

- Criar alguns dados falsos para testes utilizando o comando 

``` 
php artisan db:seed
``` 

- Por fim, basta rodar o comando 

``` 
php artisan server
``` 

e utilizar a aplicação.

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
* [Composer](https://getcomposer.or) - Gerente de Dependências
* [Faker PHP](https://fakerphp.org/) - Gerador de dados falsos



