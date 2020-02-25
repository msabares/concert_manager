# API
The API provides CRUD for Concert and provide authentication and access control for Users. What makes this possible is the use of the following compnents:
* [API Platform](https://api-platform.com/) - Used for CRUD, Access Control per field and entity
* [LexikJWTAuthenticationBundle](https://github.com/lexik/LexikJWTAuthenticationBundle) - Used to secure the API and authenticate users via JWT tokens.
* [maker-bundle](https://symfony.com/doc/current/bundles/SymfonyMakerBundle/index.html) -  To automatically build our user class with the proper configurations for authentication 
* [security-bundle](https://symfony.com/doc/current/security.html) - Handles the authentication and the distributing of the token?



## Getting Started
The API is built using Symfony for back end development. To get started, you'll need to install Symfony and any dependencies/packages the project requires.

### Requirements
Before we can work on our development environment, the following is required to be installed:
* Install PHP 7.2.5 or higher
* Install [Composer](https://getcomposer.org/download/)
* Install [Symfony](https://symfony.com/download) </br>

### Install Dependencies
Within the api directory, use the following command
```
composer install
```

## Useful Commands
### Initialize and Manage Database
Create database
```
php bin/console doctrine:database:create
```

Updating the Schema of the database (If you add new or modified an existing class)
```
php bin/console make:migration

php bin/console doctrine:migrations:migrate
```


_NOTE: There is nothing in the project to natively allow you to compile the api for development. You may have to install additional components or use an IDE's feature to allow this._
