ToDoList
========
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/78334f2328c44c3fbabc785240222905)](https://www.codacy.com/gh/fra9106/todoList/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=fra9106/todoList&amp;utm_campaign=Badge_Grade)

Project basis #8 : Improve an existing project 

https://openclassrooms.com/projects/ameliorer-un-projet-existant-1

## Context :

Your role here is therefore to improve the quality of the application. Quality is a concept that encompasses many subjects: we often talk about code quality, but there is also the quality perceived by the user of the application or the quality perceived by the company's employees, and and finally the quality that you perceive when you have to work on the project.

Thus, for this last specialization project, you are in the shoes of an experienced developer in charge of the following tasks:

     the implementation of new features;
     the correction of some anomalies;
     and the implementation of automated tests...

# Install :
## Clone repo :
```
https://github.com/fra9106/todoList.git
```
## Install Composer (dependency)
```
https://getcomposer.org/download
```
## Create your data base :
```
php bin/console doctrine:database:create
```
## Execute your migration :
```
php bin/console doctrine:migrations:migrate
```
## Execute your fixtures :
```
php bin/console doctrine:fixtures:load --no-interaction
```
## Credentials
```
ROLE_ADMIN : 

    username : bibi@admin.fr 
    password : bibi

ROLE_USER  : 

    username : toto@user.fr 
    password : toto

ROLE_ANONYMOUS  : 

    username : anonymous@symfony.com
    password : anonymous
```
## Env project development :
```
- PHP : 7.4.9
- MySQL : 5.7.31
- Symfony : 5.2.5
- Composer : 2.0.9
- Codacy
- Github

and Enjoy it! ;=)
```
