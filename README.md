# Sistema de Gerenciamento de Pousada — Laravel

Trabalho prático desenvolvido em PHP com framework Laravel, seguindo o padrão MVC.


## Mapeamento dos Requisitos

| Requisito | Status | Detalhes |
|---|---|---|
| PHP + Laravel | ✅ | Framework Laravel (padrão MVC) |
| Página inicial | ✅ | welcome.blade.php — acesso público com links de Login e Registro |
| Dashboard com menus | ✅ | Sidebar com navegação entre todos os módulos |
| ≥ 3 CRUDs básicos (sem FK) | ✅ | Categorias de Quarto, Hóspedes, Funcionários |
| ≥ 1 CRUD com FK | ✅ | Quartos (FK → categorias_quarto) e Reservas (FK → hospedes, quartos, funcionarios) |
| Padrão MVC | ✅ | Models, Controllers, Views separados |
| Migrations | ✅ | 5 migrations (categorias_quarto, hospedes, funcionarios, quartos, reservas) |
| Paginação | ✅ | ->paginate(10) em todos os índices |
| Tela de pesquisa | ✅ | Busca por texto em todos os módulos |
| Criptografia de rotas | ✅ | encrypt() / decrypt() nos IDs das rotas |


## Estrutura do Projeto
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
│   │   ├── app.blade.php       
│   │   └── auth.blade.php      
│   ├── welcome.blade.php       
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

## Diagrama do Banco de Dados
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

## Funcionalidades implementadas

- **Autenticação completa** — Login, Registro e Logout com proteção de rotas via middleware auth
- **Página inicial pública** — Apresentação do sistema com acesso a Login e Registro
- **Dashboard** — Resumo com cards de totais e tabela das últimas reservas
- **5 CRUDs completos** — Listagem, Visualização, Criação, Edição e Exclusão
- **Paginação** — 10 registros por página em todas as listagens
- **Pesquisa** — Filtro por texto em todos os módulos; reservas e quartos têm filtro por status
- **Criptografia de rotas** — IDs criptografados com encrypt()/decrypt() do Laravel
- **Validações** — Todas as regras de negócio com mensagens em português
- **Proteção de exclusão** — Impede excluir registros com dependências (FK)
- **Cálculo automático** — Valor total da reserva calculado por diária × número de dias
- **Bootstrap 5 + Bootstrap Icons** — Interface responsiva e moderna
