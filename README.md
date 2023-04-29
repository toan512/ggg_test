# Amazon Shipping Service (GGG Test)
Tested on :
- Window 10
- XAMPP Version 7.3.11 (Control Panel Version: 3.2.4)
- PHP Version : 7.4.27 
- MySQL Version : 10.4.8-MariaDB
- PHP extension: mysqli, curl, mbstring 

**Becare : Maybe you will get some error when runing in PHP 8.x or higher**

Any question contact via email : toan512@gmail.com

## Feature : 
- Get product information from the website amazon.com
- Easily install, configure and expand the product attributes
- Add or customize various types of fees easily

**NOTE : This version only support Amazon product Weight(pounds), Dimensions(inches)**
## Framework : 
- Laravel Framework 8.83.23

## Setup (**Important**) : 
Config DB

```
1. File db in example in ./db_data/db.sql
2. import database to mysql 
3. config database in .env
```
Config amazon bypass I'm Not Robot (Get header cookie)

```
1. Login amazon account in amazon.com with Google Chrome
2. Right click with element in amazon.com website 
3. Choose 'inspect' 
4. Active tab 'Network'
5. Reload website, and click request has "Request URL" from "https://www.amazon.com", you can see in image red color
6. Copy cookie value and paste in .env Variable AMAZON_COOKIE. Example : AMAZON_COOKIE = "cookie_value_here"
```

![Image Show](https://soistories.one/cv/images/tut2.jpg)

## Run Laravel :
In Laravel folder, open terminal or cmd to run command (PHP required)
- php artisan key:generate
- php artisan serve
After run you will get some thing like this : PHP 7.4.27 Development Server (http://127.0.0.1:8000) started
Website will url is : http://127.0.0.1:8000

## Database design EAV Pattern :
**Use EAV Pattern for easy expand attribute product**
![Image Show](https://soistories.one/cv/images/eav_design.jpg)

## Tutorial config product attribute : 
- Weight item, Width item, Height item, Depth item is lock attribute, can't remove
- Config product attribute need use Regular expression
- Product Attribute Name is unique, required and Only accpet letter normal a-z and character _ 
- Regular expression : regex html (view source amazon.com/product for get it) get attribute data
- Regular expression index : is index of value attribute when use **preg_match()** of php 
- Attribute Value Type : use for fee config conditional, Both text and number are supported for configuring conditional fees, but when calculator fee this version only support number.

## Tutorial config fee : 
- Shipping fee = Max(fee_1, fee_2, fee_3,...) in config
- For fee config conditional see fee name : example_config_conditional in database example.
- Conditional fees configuration is always prioritized, if the condition is met, that configuration will be used, otherwise the default configuration fee will be used.
- The database design can easily expand the configuration of multiple conditional fees
- fee config : attribute need used in ||, example : |product_width|.
- In fee config, you can write it as an operation using variable values from the product's attributes

