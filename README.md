# Teste dev para Uello

#### O que fiz:

 - [x] Importação e exportação do csv.
 - [x] Parse do endereço, separando e colocando os dados de uma forma que considerei mais adequada no banco.
incluíndo **latitude**, **longitude** e **place_id** (que usei nos requests para a API).
 - [x] Exibição dos dados em uma tabela estilizada pelo Bootstrap 4. Tanto dos dados importados como das rotas otimizadas.
 - [x] Patterns utilizados: **Facade** (no pacote que fiz) e **Repository** (para lidar com os dados).
 - [x] Análise da melhor rota entre todos os endereços.
		 Não fiz nenhum algorítimo super específico, até porque demandaria bastante tempo. Utilizei a própria API do **google directions** para fazer essa parte, usando o **way points optimization** da própria API.

*Obs: Usei como **destination** o primeiro registro da lista.
Eu poderia ter feito uma request para a API para descobrir o endereço mais longe e usá-lo como **destination**. Não fiz para otimizar o tempo.*

#### O que não fiz

 - [ ] Escrever testes

# Stack

 - Laravel 7
 - Docker
 - MySql

#### Pacotes de terceiros utilizados:

 - [Collection of Google Maps API Web Services for Laravel 7](https://github.com/alexpechkarev/google-maps)
	(Utilizado para realizar requisições para a API do Google.)

#### Minhas implementações:

**Controllers:** 
> application/app/Http/Controllers

**Requests**
> application/app/Http/Requests

**Repositories**
> application/app/Repository

**Model**
> application/app/Customer.php

**Migration**
> application/database/migrations/2020_05_19_044146_create_customers_table.php

**Meu *package***
> application/packages/jarbas/routes

**Views**
> application/resources/views

**Routes**
> application/routes/web.php

# Subir o Projeto

Dentro da pasta `application` basta rodar `composer install`

Rode `php artisan vendor:publish --tag=googlemaps` para publicar o arquivo de configurações do google maps. Em seguida edite o arquivo `./application/config/googlemaps.php` e adicione uma key do Google Maps em **key**.

De dentro da pasta `docker` rode o comando `docker-compose up -d`. É importante estar dentro da pasta `docker` para que o *.env* seja utilizado corretamente.

| Porta local web | Porta local mysql | Usuário mysql | Senha mysql | Banco |
|--|--|--|--|--|
| 80 | 3306 | uello | (sem senha) | uello |

*essas configurações podem ser alteradas em `./docker/.env`*

Após subir o projeto, pode ser utilizado o arquivo .`/structure.sql` para criar a estrutura do banco ou rodar as migrations do Laravel.

That's it for now, enjoy!