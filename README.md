# 📚 API Plataforma de Ensino - Professor Jubilut

API REST desenvolvida em **Laravel** para gerenciar alunos, cursos e matrículas de uma plataforma de ensino online.

## 🎯 **O que esta API faz?**

- **Gerencia Alunos**: Cadastra, lista, atualiza e exclui estudantes
- **Gerencia Cursos**: Cria e organiza áreas de cursos (Biologia, Química, etc.)
- **Controla Matrículas**: Matricula alunos nos cursos (apenas administradores)
- **Busca Inteligente**: Filtra alunos por nome e email
- **Validações**: Garante dados corretos e únicos

## 🛠️ **Tecnologias**

- **Laravel 12** - Framework PHP
- **SQLite** - Banco de dados (mais simples para estudos)
- **Postman** - Para testar a API

## ⚡ **Instalação Rápida**

### 1. **Pré-requisitos**
- PHP 8.2+
- Composer
- Laragon (Windows)

### 2. **Configuração**
```bash
# 1. Instalar dependências
composer install

# 2. Gerar chave da aplicação
php artisan key:generate

# 3. Executar migrações (criar tabelas)
php artisan migrate

# 4. Iniciar servidor
php artisan serve
```

### 3. **Acessar API**
- **URL Base**: `http://127.0.0.1:8000/api`
- **Documentação**: `http://127.0.0.1:8000/api/docs`

## 📋 **Endpoints Principais**

### **Alunos**
| Método | Endpoint | Descrição |
|--------|----------|-----------|
| GET | `/api/alunos` | Listar todos os alunos |
| GET | `/api/alunos/{id}` | Buscar aluno específico |
| POST | `/api/alunos` | Criar novo aluno |
| PUT | `/api/alunos/{id}` | Atualizar aluno |
| DELETE | `/api/alunos/{id}` | Excluir aluno |

### **Áreas de Cursos**
| Método | Endpoint | Descrição |
|--------|----------|-----------|
| GET | `/api/areas-cursos` | Listar cursos |
| GET | `/api/areas-cursos/{id}` | Buscar curso específico |
| POST | `/api/areas-cursos` | Criar novo curso |
| PUT | `/api/areas-cursos/{id}` | Atualizar curso |
| DELETE | `/api/areas-cursos/{id}` | Excluir curso |

### **Matrículas** (Apenas Administradores)
| Método | Endpoint | Descrição |
|--------|----------|-----------|
| GET | `/api/matriculas` | Listar matrículas |
| POST | `/api/matriculas` | Criar matrícula |
| PUT | `/api/matriculas/{id}` | Atualizar matrícula |
| DELETE | `/api/matriculas/{id}` | Excluir matrícula |

## 🧪 **Testando no Postman**

### **1. Criar Aluno**
```http
POST http://127.0.0.1:8000/api/alunos
Content-Type: application/json

{
    "nome": "João Silva",
    "email": "joao@email.com",
    "data_nascimento": "1995-05-15"
}
```

### **2. Criar Curso**
```http
POST http://127.0.0.1:8000/api/areas-cursos
Content-Type: application/json

{
    "titulo": "Biologia",
    "descricao": "Curso completo de Biologia"
}
```

### **3. Criar Matrícula** (Precisa de token de admin)
```http
POST http://127.0.0.1:8000/api/matriculas
Content-Type: application/json
X-Admin-Token: admin123456

{
    "aluno_id": 1,
    "area_curso_id": 1,
    "status": "ativa"
}
```

## 🔐 **Sistema de Permissões**

### **Usuários Normais**
- ✅ Listar e visualizar dados
- ❌ Criar/editar/excluir matrículas

### **Administradores**
- ✅ Todas as operações
- 🔑 **Token**: `admin123456`
- 📝 **Header**: `X-Admin-Token: admin123456`

## 📊 **Estrutura do Banco**

```
alunos
├── id (PK)
├── nome
├── email (único)
└── data_nascimento

area_cursos
├── id (PK)
├── titulo (único)
└── descricao

matriculas
├── id (PK)
├── aluno_id (FK)
├── area_curso_id (FK)
├── status (ativa/inativa/concluida)
└── data_matricula
```

## 🎯 **Exemplo de Uso Completo**

### **1. Criar dados base**
```bash
# Criar aluno
POST /api/alunos
{"nome": "Maria Santos", "email": "maria@email.com"}

# Criar curso
POST /api/areas-cursos
{"titulo": "Matemática", "descricao": "Curso de Matemática"}
```

### **2. Matricular aluno** (como admin)
```bash
POST /api/matriculas
X-Admin-Token: admin123456
{"aluno_id": 1, "area_curso_id": 1, "status": "ativa"}
```

### **3. Verificar matrícula**
```bash
GET /api/matriculas/aluno/1
```

## ⚠️ **Validações Importantes**

- **Email único** para alunos
- **Título único** para cursos
- **Matrícula única** por aluno/curso
- **Data de nascimento** anterior a hoje
- **Status válido**: ativa, inativa, concluida

## 🚀 **Comandos Úteis**

```bash
# Ver status das migrações
php artisan migrate:status

# Recriar banco do zero
php artisan migrate:fresh

# Limpar cache
php artisan cache:clear

# Ver rotas disponíveis
php artisan route:list
```

## 📝 **Respostas da API**

### **Sucesso (200/201)**
```json
{
    "success": true,
    "message": "Operação realizada com sucesso",
    "data": { ... }
}
```

### **Erro (400/422)**
```json
{
    "success": false,
    "message": "Dados inválidos",
    "errors": { ... }
}
```

### **Acesso Negado (403)**
```json
{
    "success": false,
    "message": "Acesso negado. Apenas administradores podem criar matrículas."
}
```

## 🎓 **Para Estudantes**

Este projeto demonstra:
- **API REST** com Laravel
- **Relacionamentos** entre tabelas
- **Validações** de dados
- **Sistema de permissões** simples
- **Estrutura MVC** organizada
- **Testes** com Postman

## 🔧 **Solução de Problemas**

### **Erro: "Call to undefined relationship"**
- Execute `composer install` para reinstalar dependências

### **Erro: "Table already exists"**
- Execute `php artisan migrate:fresh` para recriar banco

### **Erro: "Connection refused"**
- Verifique se o servidor está rodando com `php artisan serve`

---
