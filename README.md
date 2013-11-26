php-ddd-cargo-sample
====================

PHP version of the cargo sample used in Eric Evans DDD book

Introduction
------------
This project is work in progress. Your welcome to fork the repo and help finishing the cargo sample application for php.
The application layer is based on ZF2 and we use Doctrine2 to persist our aggregates. 
This would be a common combination in a large PHP project but both frameworks are not required. They just make our life easier 
and let us focus on the Domain Driven Design implementation. Both can be replaced with any other PHP based components.

The original cargo sample written in java can be found [here](http://dddsample.sourceforge.net/).

Installation
------------

Using Git and Composer (recommended)
-----------------------------------
Clone the repository and manually invoke `composer` using the shipped
`composer.phar`:

    cd my/www/dir
    git clone https://github.com/codeliner/php-ddd-cargo-sample.git
    cd php-ddd-cargo-sample
    php composer.phar self-update
    php composer.phar install

(The `self-update` directive is to ensure you have an up-to-date `composer.phar`
available.)

Setup a Database
----------------
Our sample works with a MySql database so you need a running MySql Server and an
empty test db called `cargo_sample`. Then you can use the [cargo_sample.sql](https://github.com/codeliner/php-ddd-cargo-sample/blob/master/scripts/cargo_sample.sql) to create all
required tables, but beware that each release chips with it's own `cargo_sample.sql`.
When you switch from one chapter to another you have to recreate the database schema.
Finally copy and rename the [local.php.dist](https://github.com/codeliner/php-ddd-cargo-sample/blob/master/config/autoload/local.php.dist) to `local.php`
and fill in your database credentials.

Web Server Setup
----------------

### Apache Setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

    <VirtualHost *:80>
        ServerName cargo-sample.localhost
        DocumentRoot /path/to/php-ddd-cargo-sample/public
        SetEnv APPLICATION_ENV "development"
        <Directory /path/to/php-ddd-cargo-sample/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>

Goal of the Project
-------------------
We want to show the PHP way of implementing Domain Driven Design with the help of
the originial Cargo sample used in Eric Eveans book 
`Domain Driven Design: Tackling Complexity in the Heart of Software`.
This has already been done using java and a C# version is also available.
The sample is not meant to be as the one and only way. It should help you understand the theory
and gives you a starting point. Also see the [Caveats](http://dddsample.sourceforge.net/) of the 
java implementation. The same applies for our version. 

Iterative Implementation
------------------------
To go with you when you read the book, our sample has a [release of each chapter](https://github.com/codeliner/php-ddd-cargo-sample#chapter-overview). So you can
simply `git checkout ChapterOne` and you only get the starting view of the domain
with just to entities `Cargo` and `Voyage`. Our application evolves chapter by chapter
the more knowledge we get about the domain. You can find a list of all available chapters below.

Behavior Driven Design
----------------------
All features of the application are described in feature files. You can find them in
the [features folder](https://github.com/codeliner/php-ddd-cargo-sample/tree/master/features) of the project.
We make use of [Behat](http://behat.org/) and [Mink](http://mink.behat.org/) to test our
business expectations. 

Unit Tests
----------
Unit Tests are of course also available. You can find them in the [application module](https://github.com/codeliner/php-ddd-cargo-sample/tree/master/module/Application/tests).

Project Structure
-----------------
There is no problem if you don't know the structure of a ZF2 application. All the important
parts like the domain and the infrastructure implementation can be found in the [namespace](https://github.com/codeliner/php-ddd-cargo-sample/tree/master/module/Application/src/Application) of the application module.

Chapter Overview
----------------

###ChapterOne
`git checkout ChapterOne`
Chapter One release contains the first draft of the Cargo DDD model. 
It contains the Entities `Cargo` and `Voyage` and also an `Application BookingService` that works with an `overbooking policy` 
to allow the booking of a Cargo even when the Voyage has not enough free capacity.

Support
-------
If you have any problems with the application please let me know and send me an email `kontakt[at]codeliner[dot]ws`.

