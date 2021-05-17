<p align="center">Mentes Notáveis Laravel</p>
API que terá os recursos abaixo:

- CRUD de usuário
- Obter endereços
- Obter endereço por id
- Obter Cidades
- Obter Cidades por id
- Obter Estados
- Obter Estado por id
- Obter total de usuários cadastrados por cidade
- Obter total de usuários cadastrados por estado


### Instalação

Ambiente local, considerando que você já tenha o PHP e o Composer instalado.

- Clonar o projeto
```bash
git clone https://github.com/bandrade93/mentes-notaveis-laravel.git && cd mentes-notaveis-laravel
```

- Instalação de pacotes do composer:
```bash
composer install
```

- Copiar arquivo .env
```bash
cp .env.example .env
```

- Criar Laravel key
```bash
php artisan key:generate
```

- Instalação da base de dados (Após criar a base "mentes-notaveis"):
```bash
php artisan migrate
```

- Gerar dados na tabela de states, cities e address:
```bash
php artisan db:seed
````

- Rodar aplicação:
```bash
php artisan serve
````

Requisições da api feitos pelo Insomnia

- Requisições GET

```bash
http://127.0.0.1:8000/states
http://127.0.0.1:8000/states/{id}
http://127.0.0.1:8000/cities
http://127.0.0.1:8000/cities/{id}
http://127.0.0.1:8000/address
http://127.0.0.1:8000/address/{id}
http://127.0.0.1:8000/users
http://127.0.0.1:8000/users/{id}
```

- Requisições PUT, PATCH, POST (Via insomnia), passar arquivo localizado na pasta public/json
```bash
http://127.0.0.1:8000/users
http://127.0.0.1:8000/users/{id}
```

### Sobre

#### Requerimentos

- Essa API trabalha com PHP (^7.3)
- Mysql (8.0.18)

#### Files for review
```bash
app/
├── Address.php
├── City.php
├── State.php
├── User.php
├── Http
│   ├── Controllers
│   │   ├── AddressController.php
│   │   ├── CityController.php
│   │   ├── StateController.php
│   │   ├── UserController.php
│   ├── Requests
│   │   ├── UserRequest.php

database/
├── migrations
│   ├── 2021_05_14_003852_create_states_table.php
│   ├── 2021_05_14_004139_create_cities_table.php
│   ├── 2021_05_14_185020_create_address_table.php
│   └── 2021_05_14_185320_create_users_table.php
└── seeds
    ├── AddressSeeder.php
    ├── CitySeeder.php
    └── StateSeeder.php
public/
├── json
└── └── user.json
```
