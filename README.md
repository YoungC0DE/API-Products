# API Products

> I do this API to learn about PHP
> and improviment myself

In this API we have some functionalities

| method | end point          |
|--------|--------------------|
| [POST] | /users/register    | 
| [POST] | /users/login       |
| [POST] | /products/register |
| [PUT]  | /users/edit        |
| [PUT]  | /products/edit     |
| [GET]  | /products/list     |
| [GET]  | /products/list/{id}|
| [GET]  | /products/total    |
| [DELETE] | /products/detete |
| [DELETE] | /usuario/detete  |

url_base: https://apiprodutosphp.dev.br

It is necessary to be logged in before consuming the other endpoints,
because the system will bring the products based on the logged in user.

This project will serve as a shopping list,
helping to organize your shopping cart.

## 

### schema to endpoint **(POST)/products/register**
```json 
  {
    "id_user": 1,     // required
    "name": "Rice",   // required
    "amount": 2,      // required
    "metric": "units",// required
    "value": 3.50     // required
  }
```

### schema to endpoint **(PUT)/products/edit**
```json 
  {
    "id_user": 1,     // required
    "id_prod": 1,     // required
    "name": "Rice",   // optional
    "amount": 2,      // optional
    "metric": "units",// optional
    "value": 3.50     // optional
  }
```

### schema to endpoint **(GET)/products/list**
```json 
  {
    "id_user": 1,  // required
    "id_prod": 1   // optional
  }
```

### schema to endpoint **(GET)/products/total**
```json 
  {
    "id_user": 1   // required
  }
```

### schema to endpoint **(DELETE)/products/delete**
```json 
  {
    "id_user": 1,  // required
    "id_prod": 1   // required
  }
```

##

### schema to endpoint **(POST)/users/login**
```json 
  {
    "email": "example@email.com", // required
    "password": "mypass"          // required
  }
```

### schema to endpoint **(POST)/users/register**
```json 
  {
    "name": "Your name",          // required
    "email": "example@email.com", // required
    "password": "mypass"          // required
  }
```

### schema to endpoint **(PUT)/users/edit**
```json 
  {
    "name": "Your name",           // optional
    "email": "example@email.com",  // optional
    "password": "mypass",          // optional
    "avatar": "https://yourimage"  // optional
  }
```

### schema to endpoint **(GET)/users/list**
```json 
  {
    "id_user": 1  // optional
  }
```

### schema to endpoint **(DELETE)/users/delete**
```json 
  {
    "email": "example@email.com",
    "password": "mypass"
  }
```
