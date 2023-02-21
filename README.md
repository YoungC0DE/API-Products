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

### **(POST)/products/register**
```json 
  {
    "id_user": 1,     
    "name": "Rice",
    "amount": 2,      
    "metric": "units",
    "value": 3.50     
  }
```

### **(PUT)/products/edit**
```json 
  {
    "id_user": 1,    
    "id_prod": 1,   
    "name": "Rice",  
    "amount": 2,      
    "metric": "units",
    "value": 3.50    
  }
```

### **(GET)/products/list**
```json 
  {
    "id_user": 1, 
    "name": "rice"   
  }
```

### **(GET)/products/total**
```json 
  {
    "id_user": 1  
  }
```

### **(DELETE)/products/delete**
```json 
  {
    "id_user": 1,  
    "id_prod": 1  
  }
```

##

### **(POST)/users/login**
```json 
  {
    "email": "example@email.com", 
    "password": "mypass"          
  }
```

### **(POST)/users/register**
```json 
  {
    "name": "Your name",          
    "email": "example@email.com",
    "password": "mypass"          
  }
```

### **(PUT)/users/edit**
```json 
  {
    "name": "Your name",           
    "email": "example@email.com",  
    "password": "mypass",         
    "avatar": "https://yourimage" 
  }
```

### **(GET)/users/list**
```json 
  {
    "id_user": 1
  }
```

### **(DELETE)/users/delete**
```json 
  {
    "email": "example@email.com",
    "password": "mypass"
  }
```
