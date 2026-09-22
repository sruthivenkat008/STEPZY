Stepzy – E-Commerce Web Application

Project Title: Stepzy – Online Footwear E-Commerce Web Application

Application Domain : E-Commerce / Online Footwear Shopping
Stepzy is a web-based footwear shopping application that allows users to browse, search, filter, and manage footwear products. PHP is used for server-side processing and MySQL is used for data storage.

Technologies Used:
- Frontend: HTML5, CSS3, JavaScript
- Backend: PHP
- Database: MySQL
- Server: Apache
- Environment: XAMPP
- Database Connection: PHP PDO
- Data Format: XML
- XML Parser: PHP SimpleXML

Main Features:
- View and search footwear products.
- Filter products by category.
- Add, view, update, and delete products.
- User registration and login.
- Store application data in MySQL.
- Read and display product data from XML.
- Basic order management.

Project Structure:

stepzy/

    index.html
    index.php

    config/
        config.php
        database.php

    database/
        stepzy_db.sql

    data/
        products_catalog.xml

    api/
        get_products.php
        crud_product.php
        orders.php
        auth.php
        subscribers.php
        xml_products.php

Requirements:
Install the following:
- XAMPP
- Apache
- MySQL
- Web browser

Installation and Setup:

Step 1: Install XAMPP
Download and install XAMPP.
Open XAMPP Control Panel.
Start:
Apache and MySQL
Both services should be running.

Step 2: Copy the Project
Copy the complete "stepzy" folder into the XAMPP "htdocs" directory.
C:\xampp\htdocs\stepzy

Step 3: Create the Database
Open your browser and go to:
http://localhost/phpmyadmin
Click Import.
Select:
stepzy/database/stepzy_db.sql
Click Go to import the database.
The "stepzy_db" database and required tables will be created.

Step 4: Check Database Connection
Open:
stepzy/config/database.php
Make sure the database settings are correct:
Host: localhost
Port: 3306
Database: stepzy_db
Username: root
Password:
For the default XAMPP MySQL setup, the password is usually empty unless you have configured one.

Step 5: Check the XML File
Make sure the XML file exists at:
stepzy/data/products_catalog.xml
The PHP application reads this file using SimpleXML.

Step 6: Run the Application
Make sure Apache and MySQL are running in XAMPP.
Open:
http://localhost/stepzy/

Step 7: Test the Application
Check that:
- Products are displayed.
- Product search/filter works.
- Products can be added, updated, and deleted.
- User registration/login works.
- Data is stored in MySQL.
- XML product data can be read/displayed.

Database:
Database Name: stepzy_db
The database contains the tables required for products, users, orders, and other application data.

Run-> Start Apache + MySQL in XAMPP and open:
http://localhost/stepzy/
