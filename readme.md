### This is my first Symfony project

It is a blog

Db scheme is here:  https://dbdesigner.page.link/gSE8mrHHL64gX3wi8

------------------------------------------

Php version: 7.2.19

Symfony version: 4.3.2

composer

npm or yarn

--------------------------------------

#### Install:

1.Clone repository

2.Run console in project folder

    
    composer install
    
then run
    
    npm install or yarn install

then
    
    gulp

and 
    
    composer require friendsofsymfony/ckeditor-bundle

to install ck-editor

#### Db setup:

1.Check that MySql is already installed on host

2.Edit line in .env file according to yours db-connection:
    
    
    DATABASE_URL=mysql://use:pass@host/DB_name
    
3.Run console in project folder to create DB
    
    
    php bin/console doctrine:database:create
    

then run migrations
    
    
     php bin/console doctrine:migrations:migrate
     
4.Run fixtures for creation Admin user and some test posts

   default login/pass: admin / admin
 
    
    bin/console hautelook:fixtures:load --append
