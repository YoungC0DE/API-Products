# API Produtos

> Fiz essa api para aprender um pouco sobre PHP 
> e me desenvolver nesta linguagem que é muito utilizada.

Nesta API teremos as seguintes funcionalidades:

| metodo | end point          |
|--------|--------------------|
| [POST] |  usuarios/register |
| [POST] |  usuarios/login    |
| [POST] |  produtos/register |
| [GET]  |  produtos/list     |
| [GET]  |  produtos/total    |

url_base: https://produtosconsulta2.000webhostapp.com

É necessário estar logado antes de consumir os outros end-points, 
pois o sistema irá trazer os produtos com base no usuario logado.

Este projeto servirá como uma lista de compras, 
ajudando a organizar algum carrinho de compras.

## Como implementar usando javascript vanilla

```js
  function login() {
    const data = {
      email: 'seuemail@email.com',
      senha: 'suasenha'
    }
    axios.post(`${url_base}/usuarios/login`, data)
    .then(resp => console.log(resp))
    .catch(e => console.log(e))
  }
  
  function cadastro_usuario() {
    const data = {
      email: 'seuemail@email.com',
      senha: 'suasenha'
    }
    axios.post(`${url_base}/usuarios/register`, data)
    .then(resp => console.log(resp))
    .catch(e => console.log(e))
  }
  
  function cadastro_produto() {
    const data = {
      nome: 'produto1',
      quantidade: 2,
      medida: 'unidade',
      valor: 3.50
    }
    axios.post(`${url_base}/produtos/register`, data)
    .then(resp => console.log(resp))
    .catch(e => console.log(e))
  }
  
  async function produtos_lista() {
    await const produtos = axios.get(`${url_base}/produtos/list`)
    return produtos // json
  }
  
  async function produtos_total() {
    await const total = axios.get(`${url_base}/produtos/total`)
    return total // json
  }
```
