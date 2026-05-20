# 🏨 Sistema de Gerenciamento de Pousada — Laravel

Trabalho prático desenvolvido em **PHP com framework Laravel**, seguindo o padrão **MVC**.

---

## 📋 Mapeamento dos Requisitos

| Requisito | Status | Detalhes |
|---|---|---|
| PHP + Laravel | ✅ | Framework Laravel (padrão MVC) |
| Página inicial | ✅ | `welcome.blade.php` — acesso público com links de Login e Registro |
| Dashboard com menus | ✅ | Sidebar com navegação entre todos os módulos |
| ≥ 3 CRUDs básicos (sem FK) | ✅ | **Categorias de Quarto**, **Hóspedes**, **Funcionários** |
| ≥ 1 CRUD com FK | ✅ | **Quartos** (FK → categorias_quarto) e **Reservas** (FK → hospedes, quartos, funcionarios) |
| Padrão MVC | ✅ | Models, Controllers, Views separados |
| Migrations | ✅ | 5 migrations (`categorias_quarto`, `hospedes`, `funcionarios`, `quartos`, `reservas`) |
| Paginação | ✅ | `->paginate(10)` em todos os índices |
| Tela de pesquisa | ✅ | Busca por texto em todos os módulos |
| Criptografia de rotas | ✅ | `encrypt()` / `decrypt()` nos IDs das rotas |

---

## 🗂️ Estrutura do Projeto

```
app/
├── Http/Controllers/
│   ├── Auth/
│   │   ├── LoginController.php
│   │   └── RegisterController.php
│   ├── DashboardController.php
│   ├── CategoriaQuartoController.php
│   ├── HospedeController.php
│   ├── FuncionarioController.php
│   ├── QuartoController.php
│   └── ReservaController.php
├── Models/
│   ├── CategoriaQuarto.php
│   ├── Hospede.php
│   ├── Funcionario.php
│   ├── Quarto.php
│   └── Reserva.php
database/migrations/
│   ├── ..._create_categorias_quarto_table.php
│   ├── ..._create_hospedes_table.php
│   ├── ..._create_funcionarios_table.php
│   ├── ..._create_quartos_table.php
│   └── ..._create_reservas_table.php
resources/views/
│   ├── layouts/
│   │   ├── app.blade.php       ← Layout autenticado (sidebar + topbar)
│   │   └── auth.blade.php      ← Layout de autenticação
│   ├── welcome.blade.php       ← Página inicial pública
│   ├── auth/login.blade.php
│   ├── auth/register.blade.php
│   ├── dashboard/index.blade.php
│   ├── categorias-quarto/{index,create,edit,show}.blade.php
│   ├── hospedes/{index,create,edit,show}.blade.php
│   ├── funcionarios/{index,create,edit,show}.blade.php
│   ├── quartos/{index,create,edit,show}.blade.php
│   └── reservas/{index,create,edit,show}.blade.php
routes/web.php
```

---

## 🗄️ Diagrama do Banco de Dados

```
users
  id | name | email | password

categorias_quarto
  id | nome | descricao | capacidade

hospedes
  id | nome | cpf | email | telefone | cidade | estado

funcionarios
  id | nome | cpf | cargo | email | telefone

quartos
  id | numero | categoria_id (FK) | preco_diaria | status | descricao

reservas
  id | hospede_id (FK) | quarto_id (FK) | funcionario_id (FK)
     | data_checkin | data_checkout | valor_total | status | observacoes
```

---

## 🚀 Instalação e Execução

### 1. Clonar e instalar dependências

```bash
# Copiar arquivos para um novo projeto Laravel
composer create-project laravel/laravel pousada
cd pousada

# Copiar os arquivos gerados para as pastas correspondentes
```

### 2. Configurar o banco de dados

Edite o arquivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pousada
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Executar migrations e iniciar

```bash
# Gerar chave da aplicação
php artisan key:generate

# Rodar as migrations
php artisan migrate

# Iniciar o servidor de desenvolvimento
php artisan serve
```

### 4. Acessar o sistema

Abra o navegador em: **http://localhost:8000**

- Página inicial → `/`
- Registro → `/register`
- Login → `/login`
- Dashboard → `/dashboard` (requer autenticação)

---

## ✨ Funcionalidades implementadas

- **Autenticação completa** — Login, Registro e Logout com proteção de rotas via middleware `auth`
- **Página inicial pública** — Apresentação do sistema com acesso a Login e Registro
- **Dashboard** — Resumo com cards de totais e tabela das últimas reservas
- **5 CRUDs completos** — Listagem, Visualização, Criação, Edição e Exclusão
- **Paginação** — 10 registros por página em todas as listagens
- **Pesquisa** — Filtro por texto em todos os módulos; reservas e quartos têm filtro por status
- **Criptografia de rotas** — IDs criptografados com `encrypt()`/`decrypt()` do Laravel
- **Validações** — Todas as regras de negócio com mensagens em português
- **Proteção de exclusão** — Impede excluir registros com dependências (FK)
- **Cálculo automático** — Valor total da reserva calculado por diária × número de dias
- **Bootstrap 5 + Bootstrap Icons** — Interface responsiva e moderna

---

## 🔐 Criptografia de Rotas

Todos os IDs nas URLs são criptografados usando o sistema de criptografia nativo do Laravel:

```php
// Na view (gerar link com ID criptografado)
route('hospedes.show', encrypt($hospede->id))

// No controller (descriptografar ao receber)
$realId = decrypt($id);
$hospede = Hospede::findOrFail($realId);
```

Isso garante que os IDs reais do banco de dados não fiquem expostos na URL.

---

## 📦 Dependências de terceiros (via CDN)

- **Bootstrap 5.3** — Framework CSS/JS
- **Bootstrap Icons 1.11** — Ícones SVG
