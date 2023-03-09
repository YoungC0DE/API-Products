# API Products

> I do this API to learn about PHP
> and improviment myself

In this API we have some functionalities

|       method          |     end point      |                 required params                   |
|-----------------------|--------------------|---------------------------------------------------|
| <code>[POST]</code>   | /users/register    | <code>name, email, password</code>                |
| <code>[POST]</code>   | /users/login       | <code>email, user</code>                          |
| <code>[POST]</code>   | /products/register | <code>id_user, name, amount, metric, value</code> |
| <code>[PUT]</code>    | /users/edit        | <code>id_user</code>                              |
| <code>[PUT]</code>    | /products/edit     | <code>id_user, id_prod</code>                     |
| <code>[GET]</code>    | /products/list     | <code>id_user</code>                              |
| <code>[GET]</code>    | /products/total    | <code>id_user</code>                              |
| <code>[DELETE]</code> | /products/detete   | <code>id_prod, id_user</code>                     |
| <code>[DELETE]</code> | /usuario/detete    | <code>id_user</code>                              |

url_base: https://apiprodutosphp.dev.br

It is necessary to be logged in before consuming the other endpoints,
because the system will bring the products based on the logged in user.

This project will serve as a shopping list,
helping to organize your shopping cart.

## /products

``` (POST)/products/register?id_user=&name=&amount=&metric=&value ```

``` (PUT)/products/edit?id_user=&id_prod=&name=&amount=&metric=&value ``` 

``` (GET)/products/list?id_user=&name= ```

``` (GET)/products/total?id_user ```

``` (DELETE)/products/delete?id_user=&id_prod ```

## /users

``` (POST)/users/login?email=&password ```

``` (POST)/users/register?name=&email=&password ```

``` (PUT)/users/edit?name=&email=&password=&avatar ```

``` (GET)/users/list?id_user ```

``` (DELETE)/users/delete?email=&password ```
