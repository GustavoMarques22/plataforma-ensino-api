# API Plataforma de Ensino

API REST desenvolvida em Laravel para gerenciar alunos, áreas de cursos e matrículas de uma plataforma de ensino online.

## Funcionalidades

- **CRUD de Áreas de Cursos**: Gerenciar áreas como Biologia, Química, Física
- **CRUD de Alunos**: Gerenciar dados dos estudantes
- **CRUD de Matrículas**: Controlar matrículas dos alunos nos cursos
- **Busca de Alunos**: Por nome e email
- **Validações**: Dados de entrada validados
- **Relacionamentos**: Um aluno pode ter múltiplas matrículas

## Tecnologias Utilizadas

- **Laravel 10.x** - Framework PHP
- **MySQL** - Banco de dados
- **Eloquent ORM** - Mapeamento objeto-relacional
- **Laravel Migrations** - Controle de versão do banco
- **Laravel Seeders** - População do banco com dados iniciais

## Instalação

### Pré-requisitos
- PHP 8.1 ou superior
- Composer
- MySQL
- Laragon (recomendado para Windows)

### Passos para instalação

1. **Clone ou extraia o projeto:**
```bash
cd C:\laragon\www
# Se clonar do Git:
git clone <url-do-repositorio> plataforma-ensino-api
# OU extraia o arquivo ZIP diretamente na pasta www
```

2. **Entre na pasta do projeto:**
```bash
cd plataforma-ensino-api
```

3. **Instale as dependências:**
```bash
composer install
```

4. **Configure o arquivo .env:**
```bash
# Copie o arquivo de exemplo
copy .env.example .env

# Configure as variáveis do banco de dados:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=plataforma_ensino
DB_USERNAME=root
DB_PASSWORD=
```

5. **Gere a chave da aplicação:**
```bash
php artisan key:generate
```

6. **Crie o banco de dados:**
- No Laragon, acesse o phpMyAdmin
- Crie um banco chamado `plataforma_ensino`

7. **Execute as migrations:**
```bash
php artisan migrate
```

8. **Execute os seeders (opcional - para dados de exemplo):**
```bash
php artisan db:seed
```

## 🚀 Execução

### Inicie o servidor de desenvolvimento:
```bash
php artisan serve
```

### Ou use o Laragon:
- Inicie o Laragon
- Acesse: `http://plataforma-ensino-api.test`

## 🌐 Endpoints da API

### Base URL
```
http://localhost:8000/api
# ou
http://plataforma-ensino-api.test/api
```

### Documentação
- **GET /api/** - Informações da API
- **GET /api/docs** - Documentação completa

### Alunos

#### Listar Alunos
```http
GET /api/alunos
GET /api/alunos?nome=João
GET /api/alunos?email=joao@email.com
GET /api/alunos?per_page=5
```

#### Buscar Aluno por ID
```http
GET /api/alunos/{id}
```

#### Criar Aluno
```http
POST /api/alunos
Content-Type: application/json

{
    "nome": "João Silva",
    "email": "joao@email.com",
    "data_nascimento": "1995-05-15"
}
```

#### Atualizar Aluno
```http
PUT /api/alunos/{id}
Content-Type: application/json

{
    "nome": "João Santos",
    "email": "joao.santos@email.com"
}
```

#### Deletar Aluno
```http
DELETE /api/alunos/{id}
```

### Áreas de Cursos

#### Listar Áreas de Cursos
```http
GET /api/areas-cursos
GET /api/areas-cursos?titulo=Biologia
GET /api/areas-cursos?per_page=5
```

#### Buscar Área de Curso por ID
```http
GET /api/areas-cursos/{id}
```

#### Criar Área de Curso
```http
POST /api/areas-cursos
Content-Type: application/json

{
    "titulo": "Biologia",
    "descricao": "Curso completo de Biologia"
}
```

#### Atualizar Área de Curso
```http
PUT /api/areas-cursos/{id}
Content-Type: application/json

{
    "titulo": "Biologia Avançada",
    "descricao": "Curso completo e avançado de Biologia"
}
```

#### Deletar Área de Curso
```http
DELETE /api/areas-cursos/{id}
```

### Matrículas

#### Listar Matrículas
```http
GET /api/matriculas
GET /api/matriculas?status=ativa
GET /api/matriculas?per_page=5
```

#### Buscar Matrícula por ID
```http
GET /api/matriculas/{id}
```

#### Criar Matrícula
```http
POST /api/matriculas
Content-Type: application/json

{
    "aluno_id": 1,
    "area_curso_id": 1,
    "status": "ativa"
}
```

#### Atualizar Matrícula
```http
PUT /api/matriculas/{id}
Content-Type: application/json

{
    "status": "concluida"
}
```

#### Deletar Matrícula
```http
DELETE /api/matriculas/{id}
```

#### Listar Matrículas de um Aluno
```http
GET /api/matriculas/aluno/{alunoId}
```

#### Listar Matrículas de uma Área de Curso
```http
GET /api/matriculas/area-curso/{areaCursoId}
```

## 📊 Estrutura do Banco de Dados

### Tabela: alunos
- `id` (PK, AUTO_INCREMENT)
- `nome` (VARCHAR, NOT NULL)
- `email` (VARCHAR, UNIQUE, NOT NULL)
- `data_nascimento` (DATE)
- `created_at`, `updated_at`

### Tabela: area_cursos
- `id` (PK, AUTO_INCREMENT)
- `titulo` (VARCHAR, UNIQUE, NOT NULL)
- `descricao` (TEXT)
- `created_at`, `updated_at`

### Tabela: matriculas
- `id` (PK, AUTO_INCREMENT)
- `aluno_id` (FK → alunos.id)
- `area_curso_id` (FK → area_cursos.id)
- `status` (ENUM: 'ativa', 'inativa', 'concluida')
- `data_matricula` (TIMESTAMP)
- `created_at`, `updated_at`

## 🧪 Testando a API

### Com cURL

#### Listar alunos
```bash
curl http://localhost:8000/api/alunos
```

#### Buscar aluno por nome
```bash
curl "http://localhost:8000/api/alunos?nome=Maria"
```

#### Criar novo aluno
```bash
curl -X POST http://localhost:8000/api/alunos \
  -H "Content-Type: application/json" \
  -d '{
    "nome": "Carlos Teste",
    "email": "carlos@teste.com",
    "data_nascimento": "1995-06-10"
  }'
```

### Com Postman

1. Importe a documentação da API acessando: `http://localhost:8000/api/docs`
2. Configure a base URL: `http://localhost:8000/api`
3. Teste todos os endpoints disponíveis

## ⚙️ Comandos Úteis

### Migrations
```bash
# Executar migrations
php artisan migrate

# Reverter última migration
php artisan migrate:rollback

# Resetar e reexecutar todas as migrations
php artisan migrate:refresh

# Resetar e popular com seeders
php artisan migrate:refresh --seed
```

### Seeders
```bash
### Seeders
```bash
# Executar todos os seeders
php artisan db:seed

# Executar seeder específico
php artisan db:seed --class=AlunoSeeder

# Limpar e popular novamente
php artisan migrate:fresh --seed
```

### Artisan
```bash
# Listar todas as rotas
php artisan route:list

# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Gerar nova chave da aplicação
php artisan key:generate
```

## 🔧 Estrutura do Projeto

```
plataforma-ensino-api/
├── app/
│   ├── Http/Controllers/
│   │   ├── AlunoController.php
│   │   ├── AreaCursoController.php
│   │   └── MatriculaController.php
│   └── Models/
│       ├── Aluno.php
│       ├── AreaCurso.php
│       └── Matricula.php
├── database/
│   ├── migrations/
│   │   ├── create_area_cursos_table.php
│   │   ├── create_alunos_table.php
│   │   └── create_matriculas_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── AreaCursoSeeder.php
│       ├── AlunoSeeder.php
│       └── MatriculaSeeder.php
├── routes/
│   └── api.php
├── .env
├── composer.json
└── README.md
```

## 📝 Validações Implementadas

### Alunos
- **nome**: obrigatório, string, máximo 255 caracteres
- **email**: obrigatório, formato email válido, único
- **data_nascimento**: opcional, formato data, deve ser anterior ao dia atual

### Áreas de Cursos
- **titulo**: obrigatório, string, máximo 255 caracteres, único
- **descricao**: opcional, string, máximo 1000 caracteres

### Matrículas
- **aluno_id**: obrigatório, deve existir na tabela alunos
- **area_curso_id**: obrigatório, deve existir na tabela area_cursos
- **status**: opcional, valores válidos: 'ativa', 'inativa', 'concluida'
- **data_matricula**: opcional, formato data

## 🔒 Regras de Negócio

1. **Email único**: Cada aluno deve ter um email único
2. **Título único**: Cada área de curso deve ter um título único
3. **Matrícula única**: Um aluno não pode ter duas matrículas ativas na mesma área de curso
4. **Exclusão protegida**: Não é possível excluir alunos ou áreas de curso que possuem matrículas ativas
5. **Relacionamentos em cascata**: Ao excluir um aluno ou área de curso, suas matrículas também são excluídas

## 🎯 Cenário de Teste Completo

### 1. Criar uma área de curso
```bash
curl -X POST http://localhost:8000/api/areas-cursos \
  -H "Content-Type: application/json" \
  -d '{
    "titulo": "História",
    "descricao": "Curso completo de História do Brasil e Mundial"
  }'
```

### 2. Criar um aluno
```bash
curl -X POST http://localhost:8000/api/alunos \
  -H "Content-Type: application/json" \
  -d '{
    "nome": "Alex Teste",
    "email": "alex@teste.com",
    "data_nascimento": "1996-08-15"
  }'
```

### 3. Matricular o aluno
```bash
curl -X POST http://localhost:8000/api/matriculas \
  -H "Content-Type: application/json" \
  -d '{
    "aluno_id": 9,
    "area_curso_id": 6,
    "status": "ativa"
  }'
```

### 4. Buscar aluno por nome
```bash
curl "http://localhost:8000/api/alunos?nome=Alex"
```

### 5. Ver matrículas do aluno
```bash
curl http://localhost:8000/api/matriculas/aluno/9
```

## ❌ Tratamento de Erros

A API retorna erros estruturados em formato JSON:

### Erro de Validação (422)
```json
{
    "success": false,
    "message": "Dados inválidos",
    "errors": {
        "email": ["O campo email já está sendo utilizado."],
        "nome": ["O campo nome é obrigatório."]
    }
}
```

### Erro de Recurso Não Encontrado (404)
```json
{
    "success": false,
    "message": "Aluno não encontrado"
}
```

### Erro de Regra de Negócio (422)
```json
{
    "success": false,
    "message": "Este aluno já possui uma matrícula ativa nesta área de curso"
}
```

### Erro Interno (500)
```json
{
    "success": false,
    "message": "Erro ao criar aluno",
    "error": "Detalhes técnicos do erro"
}
```

## 🔄 Códigos de Status HTTP

- **200** - Sucesso (GET, PUT)
- **201** - Recurso criado (POST)
- **404** - Recurso não encontrado
- **422** - Dados inválidos ou regra de negócio violada
- **500** - Erro interno do servidor

## 📱 Collection do Postman

### Configuração Base
- **Base URL**: `http://localhost:8000/api`
- **Headers**: 
  - `Content-Type: application/json`
  - `Accept: application/json`

### Requests Principais
1. **GET** Listar Alunos → `{{base_url}}/alunos`
2. **POST** Criar Aluno → `{{base_url}}/alunos`
3. **GET** Buscar Aluno → `{{base_url}}/alunos/1`
4. **PUT** Atualizar Aluno → `{{base_url}}/alunos/1`
5. **DELETE** Excluir Aluno → `{{base_url}}/alunos/1`

*(Repetir padrão para areas-cursos e matriculas)*

## 🚀 Deploy

### Preparação para Deploy
```bash
# Otimizar para produção
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Gerar chave de produção
php artisan key:generate --env=production
```

### Variáveis de Ambiente de Produção
```env
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
DB_HOST=seu-host-mysql
DB_DATABASE=plataforma_ensino
DB_USERNAME=seu-usuario
DB_PASSWORD=sua-senha
```

## 🛡️ Segurança

- **Validação de entrada**: Todos os dados são validados antes de serem processados
- **Sanitização**: Dados são automaticamente sanitizados pelo Laravel
- **Proteção SQL Injection**: Uso do Eloquent ORM previne ataques
- **CORS**: Configurado para aceitar requisições de origens permitidas

## 📈 Performance

- **Eager Loading**: Relacionamentos são carregados com `with()` para evitar N+1 queries
- **Paginação**: Implementada em todas as listagens para melhor performance
- **Índices**: Criados automaticamente pelo Eloquent em chaves estrangeiras

## 🔧 Troubleshooting

### Problema: Erro de conexão com banco
**Solução**: Verifique se o MySQL está rodando e as credenciais no .env estão corretas

### Problema: Erro 404 nas rotas da API
**Solução**: Certifique-se de acessar `/api/` antes do endpoint

### Problema: Erro de chave da aplicação
**Solução**: Execute `php artisan key:generate`

### Problema: Erro de permissão
**Solução**: No Windows/Laragon, geralmente não há problemas de permissão

## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo LICENSE para mais detalhes.

---

**Desenvolvido com ❤️ para a Plataforma de Ensino do Professor Jubilut**

### 📞 Suporte

Em caso de dúvidas ou problemas:
1. Verifique a documentação da API em `/api/docs`
2. Consulte os logs do Laravel em `storage/logs/laravel.log`
3. Execute `php artisan tinker` para testar modelos e consultas

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
