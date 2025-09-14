# 🧪 Guia de Testes no Postman

## Base URL: `http://localhost:8000/api`

### 1. **GET** - Informações da API
```
URL: {{base_url}}/
Método: GET
```

### 2. **GET** - Documentação
```
URL: {{base_url}}/docs
Método: GET
```

### 3. **POST** - Criar Área de Curso
```
URL: {{base_url}}/areas-cursos
Método: POST
Headers: Content-Type: application/json
Body (JSON):
{
    "titulo": "História",
    "descricao": "Curso completo de História"
}
```

### 4. **POST** - Criar Aluno
```
URL: {{base_url}}/alunos
Método: POST
Headers: Content-Type: application/json
Body (JSON):
{
    "nome": "Carlos Teste",
    "email": "carlos@teste.com",
    "data_nascimento": "1995-06-10"
}
```

### 5. **POST** - Criar Matrícula
```
URL: {{base_url}}/matriculas
Método: POST
Headers: Content-Type: application/json
Body (JSON):
{
    "aluno_id": 1,
    "area_curso_id": 1,
    "status": "ativa"
}
```

### 6. **GET** - Listar Alunos
```
URL: {{base_url}}/alunos
Método: GET
```

### 7. **GET** - Buscar Aluno por Nome
```
URL: {{base_url}}/alunos?nome=Carlos
Método: GET
```

### 8. **GET** - Buscar Aluno por Email
```
URL: {{base_url}}/alunos?email=carlos@teste.com
Método: GET
```

### 9. **GET** - Buscar Aluno por ID
```
URL: {{base_url}}/alunos/1
Método: GET
```

### 10. **PUT** - Atualizar Aluno
```
URL: {{base_url}}/alunos/1
Método: PUT
Headers: Content-Type: application/json
Body (JSON):
{
    "nome": "Carlos Teste Atualizado"
}
```

### 11. **GET** - Listar Matrículas do Aluno
```
URL: {{base_url}}/matriculas/aluno/1
Método: GET
```

### 12. **PUT** - Atualizar Status da Matrícula
```
URL: {{base_url}}/matriculas/1
Método: PUT
Headers: Content-Type: application/json
Body (JSON):
{
    "status": "concluida"
}
```

### Testes de Validação

### 13. **POST** - Tentar Criar Aluno com Email Duplicado (deve retornar erro)
```
URL: {{base_url}}/alunos
Método: POST
Headers: Content-Type: application/json
Body (JSON):
{
    "nome": "Outro Aluno",
    "email": "carlos@teste.com"
}
```

### 14. **POST** - Tentar Criar Aluno sem Nome (deve retornar erro)
```
URL: {{base_url}}/alunos
Método: POST
Headers: Content-Type: application/json
Body (JSON):
{
    "email": "semname@teste.com"
}
```

### 15. **DELETE** - Tentar Excluir Aluno com Matrícula Ativa (deve retornar erro)
```
URL: {{base_url}}/alunos/1
Método: DELETE
```

### 16. **GET** - Recurso Não Encontrado (deve retornar 404)
```
URL: {{base_url}}/alunos/999
Método: GET
```