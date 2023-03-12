# API Products

> I do this API to learn about PHP
> and improviment myself

In this API we have some functionalities

| method   | end point          | required params                        |
| -------- | ------------------ | -------------------------------------- |
| `POST`   | /users/register    | `name, email, password`                |
| `POST`   | /users/login       | `email, user`                          |
| `POST`   | /products/register | `user_id, name, amount, metric, value` |
| `PUT`    | /users/edit        | `user_id`                              |
| `PUT`    | /products/edit     | `user_id, prod_id`                     |
| `GET`    | /products/list     | `user_id`                              |
| `GET`    | /products/total    | `user_id`                              |
| `DELETE` | /products/detete   | `prod_id, user_id`                     |
| `DELETE` | /usuario/detete    | `user_id`                              |

url_base: https://apiprodutosphp.dev.br

It is necessary to be logged in before consuming the other endpoints,
because the system will bring the products based on the logged in user.

This project will serve as a shopping list,
helping to organize your shopping cart.

## /products

(POST) `/products/register?user_id=&name=&amount=&metric=&value`

(PUT) `/products/edit?user_id=&prod_id=&name=&amount=&metric=&value`

(GET) `/products/list?user_id=&name=`

(GET) `/products/total?user_id`

(DELETE) `/products/delete?user_id=&prod_id`

## /users

(POST) `/users/login?email=&password`

(POST) `/users/register?name=&email=&password`

(PUT) `/users/edit?name=&email=&password=&avatar`

(GET) `/users/list?user_id`

(DELETE) `/users/delete?email=&password`
