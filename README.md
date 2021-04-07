# E-commerce API
This project is intended as a school assignment and is an exercise in PHP with MySQL and an introduction to APIs.

The purpose of the project is to make an API for an e-commerce platform with the following requirements:
- Users can register and login
- Products can be created, read, updated and deleted
- Users can add and remove products to cart and also checkout cart
- Use of active sessions: user will have to login again if being inactive for a certain period of time to regain certain permissions

## Install and use 
1. You need Apache and MySQL installed on your computer
1. Clone the project into the document root directory of Apache. Example: C:\xampp\htdocs
2. Start Apache and MySQL server
3. Create database by running the script of CreateDB.sql in your MySQL database tool (like phpmyadmin or MySQL workbench)
4. Adjust settings in config/db.php if needed
5. Enter your local server host name in the URL field and add endpoint. Example: localhost/v1/users/register.php/

## Endpoints
Register user:
> /v1/users/register.php/?email={email}&username={username}&password={password}

Login user:
> /v1/users/login.php/?username={username}&password={password}

Create products:
> /v1/products/create.php/?name={name}&price={price}

Read products:
> /v1/products/read.php/

Update products:
> /v1/products/update.php/?id={id}name={name}&price={price}

Delete products:
> /v1/products/delete.php/?id={id}

Add product to cart:
> /v1/cart/addProduct.php?product_id{product_id}&token={token}

Remove product from cart:
> /v1/cart/removeProduct.php?product_id{product_id}&token={token}

Checkout cart:
> /v1/cart/checkout.php?token={token}
