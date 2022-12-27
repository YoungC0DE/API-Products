# API Produtos

> Fiz essa api para aprender um pouco sobre PHP 
> e me desenvolver nesta linguagem que é muito utilizada.

Nesta API teremos as seguintes funcionalidades:

| metodo | end point          |
|--------|--------------------|
| [POST] |  /usuarios/register |
| [POST] |  /usuarios/login |
| [POST] |  /produtos/register/{id_usuario} |
| [GET]  |  /produtos/list/{id_usuario} |
| [GET]  |  /produtos/total/{id_usuario} |
| [DELETE] |  /produtos/detete/{id_usuario} |
| [DELETE] |  /usuario/detete |

url_base: https://apiprodutosphp.dev.br

É necessário estar logado antes de consumir os outros end-points, 
pois o sistema irá trazer os produtos com base no usuario logado.

Este projeto servirá como uma lista de compras, 
ajudando a organizar algum carrinho de compras.

### schema para o endpoint **/produtos/register/**
```json 
  {
    "id_usuario": 1,
    "nome": "Arroz",
    "quantidade": 2,
    "medida": "Pacotes",
    "valor": 3.50
  }
```

### schema para o endpoint **/usuarios/register/**
```json 
  {
    "nome": "usuario",
    "email": "exemplo@email.com",
    "senha": "12345"
  }
```

### schema para o endpoint **/usuarios/login/**
```json 
  {
    "email": "exemplo@email.com",
    "senha": "12345",
  }
```

### schema para o endpoint **/usuarios/delete/**
```json 
  {
    "email": "exemplo@email.com",
    "senha": "12345",
  }
```
