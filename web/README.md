# Classroom Reserve

Sistema de reserva de salas para uso em ambiente educacional, criado com Laravel 12. Este projeto permite gerenciar salas, responsáveis e reservas de forma simples, com autenticação e CRUD completo.

## Funcionalidades

- Autenticação de usuários via login e senha.
- Painel administrativo com visão geral de reservas e estatísticas.
- Cadastro, edição e exclusão de salas.
- Cadastro, edição e exclusão de responsáveis.
- Cadastro, edição, cancelamento e exclusão de reservas.
- Filtro de reservas por sala e por data.
- Validação de horários e status de reserva.

## Tecnologias usadas

- PHP 8.2
- Laravel 12
- Blade templates
- Tailwind CSS via Vite
- Axios
- Sanctum

## Estrutura principal

- `app/Models/Room.php` — modelo de salas
- `app/Models/Responsible.php` — modelo de responsáveis
- `app/Models/Reservation.php` — modelo de reservas
- `routes/web.php` — rotas web do sistema
- `app/Http/Controllers/Web/RoomController.php` — CRUD de salas
- `app/Http/Controllers/Web/ResponsibleController.php` — CRUD de responsáveis
- `app/Http/Controllers/Web/ReservationController.php` — CRUD de reservas e cancelamentos
- `app/Http/Controllers/Web/DashboardController.php` — painel de controle
- `app/Http/Controllers/AuthController.php` — login e logout

## Requisitos

- PHP 8.2 ou superior
- Composer
- Node.js e npm
- Extensões PHP recomendadas: `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`

## Instalação

1. Clone o repositório:

   ```bash
   git clone <url-do-repositorio> classroom-reserve
   cd classroom-reserve/web
   ```

2. Instale dependências PHP e JS:

   ```bash
   composer install
   npm install
   ```

3. Crie o arquivo `.env`:

   ```bash
   cp .env.example .env
   ```

4. Gere a chave da aplicação:

   ```bash
   php artisan key:generate
   ```

5. Configure a conexão de banco de dados em `.env`.

6. Execute as migrations:

   ```bash
   php artisan migrate
   ```

7. Compile os assets:

   ```bash
   npm run build
   ```

## Uso em desenvolvimento

Para iniciar o servidor local:

```bash
php artisan serve
```

Para rodar o Vite em modo de desenvolvimento:

```bash
npm run dev
```

## Comandos úteis

- `composer install` — instala dependências PHP
- `npm install` — instala dependências Node
- `php artisan migrate` — aplica migrations
- `php artisan serve` — inicia servidor local
- `npm run dev` — executa Vite em modo desenvolvimento
- `npm run build` — gera assets de produção

## Rotas importantes

- `/login` — tela de login
- `/dashboard` — painel de controle
- `/rooms` — gerenciamento de salas
- `/responsibles` — gerenciamento de responsáveis
- `/reservations` — gerenciamento de reservas

## API REST

A API está disponível em `/api` e utiliza autenticação via token do Laravel Sanctum.

### Autenticação

- `POST /api/login`

Request:
```json
{
  "email": "usuario@example.com",
  "password": "senha123"
}
```

Success response:
```json
{
  "token": "seu-token-de-acesso"
}
```

Use o token no cabeçalho das requisições protegidas:

```
Authorization: Bearer seu-token-de-acesso
```

### Salas

- `GET /api/rooms` — lista todas as salas
- `POST /api/rooms` — cria uma nova sala
- `DELETE /api/rooms/{room}` — remove uma sala

Request para criar sala:
```json
{
  "name": "Sala 101",
  "capacity": 30,
  "location": "Bloco A",
  "equipment": "TV, Projetor",
  "description": "Sala com recursos multimídia",
  "status": "ativa"
}
```

Response de sala criada:
```json
{
  "id": 1,
  "name": "Sala 101",
  "capacity": 30,
  "location": "Bloco A",
  "equipment": ["TV", "Projetor"],
  "description": "Sala com recursos multimídia",
  "status": "ativa",
  "created_at": "2026-06-09T12:00:00.000000Z",
  "updated_at": "2026-06-09T12:00:00.000000Z"
}
```

### Responsáveis

- `GET /api/responsibles` — lista responsáveis (paginado)
- `POST /api/responsibles` — cria um responsável
- `DELETE /api/responsibles/{responsible}` — remove um responsável

Request para criar responsável:
```json
{
  "name": "João Silva",
  "email": "joao@example.com",
  "phone": "(11) 99999-9999",
  "department": "TI",
  "description": "Responsável pela sala de informática"
}
```

Response de responsável criado:
```json
{
  "id": 1,
  "name": "João Silva",
  "email": "joao@example.com",
  "phone": "(11) 99999-9999",
  "department": "TI",
  "description": "Responsável pela sala de informática",
  "created_at": "2026-06-09T12:00:00.000000Z",
  "updated_at": "2026-06-09T12:00:00.000000Z"
}
```

### Reservas

- `GET /api/reservations` — lista reservas do usuário autenticado
- `POST /api/reservations` — cria uma nova reserva
- `PATCH /api/reservations/{reservation}/cancel` — cancela uma reserva
- `GET /api/reservations/by-room/{room_id}` — lista reservas por sala
- `GET /api/reservations/by-date/{date}` — lista reservas por data (YYYY-MM-DD)

Request para criar reserva:
```json
{
  "title": "Reunião de equipe",
  "room_id": 1,
  "responsible_id": 2,
  "start_time": "2026-06-20 10:00:00",
  "end_time": "2026-06-20 12:00:00",
  "description": "Reunião para revisar o projeto",
  "status": "ativa"
}
```

Response de reserva criada:
```json
{
  "id": 1,
  "room_id": 1,
  "responsible_id": 2,
  "user_id": 3,
  "title": "Reunião de equipe",
  "description": "Reunião para revisar o projeto",
  "start_time": "2026-06-20T10:00:00.000000Z",
  "end_time": "2026-06-20T12:00:00.000000Z",
  "status": "ativa",
  "created_at": "2026-06-09T12:00:00.000000Z",
  "updated_at": "2026-06-09T12:00:00.000000Z",
  "room": {
    "id": 1,
    "name": "Sala 101",
    "capacity": 30,
    "location": "Bloco A",
    "equipment": ["TV", "Projetor"],
    "description": "Sala com recursos multimídia",
    "status": "ativa",
    "created_at": "2026-06-09T12:00:00.000000Z",
    "updated_at": "2026-06-09T12:00:00.000000Z"
  },
  "responsible": {
    "id": 2,
    "name": "João Silva",
    "email": "joao@example.com",
    "phone": "(11) 99999-9999",
    "department": "TI",
    "description": "Responsável pela sala de informática",
    "created_at": "2026-06-09T12:00:00.000000Z",
    "updated_at": "2026-06-09T12:00:00.000000Z"
  }
}
```

Response de cancelamento:
```json
{
  "message": "Reserva cancelada com sucesso.",
  "reservation": {
    "id": 1,
    "room_id": 1,
    "responsible_id": 2,
    "user_id": 3,
    "title": "Reunião de equipe",
    "description": "Reunião para revisar o projeto",
    "start_time": "2026-06-20T10:00:00.000000Z",
    "end_time": "2026-06-20T12:00:00.000000Z",
    "status": "cancelada",
    "created_at": "2026-06-09T12:00:00.000000Z",
    "updated_at": "2026-06-09T12:00:00.000000Z",
    "room": { ... },
    "responsible": { ... }
  }
}
```

### Campos importantes dos modelos

#### Sala (`Room`)
- `id`
- `name`
- `capacity`
- `location`
- `equipment` (array)
- `description`
- `status` (`ativa`, `inativa`)
- `created_at`
- `updated_at`

#### Responsável (`Responsible`)
- `id`
- `name`
- `email`
- `phone`
- `department`
- `description`
- `created_at`
- `updated_at`

#### Reserva (`Reservation`)
- `id`
- `room_id`
- `responsible_id`
- `user_id`
- `title`
- `description`
- `start_time`
- `end_time`
- `status` (`pendente`, `ativa`, `cancelada`)
- `created_at`
- `updated_at`

## Observações

- A reserva é criada apenas se a sala estiver com status `ativa`.
- O cancelamento de reservas altera o status para `cancelada`.

## Licença

Projeto licenciado sob a licença MIT.
