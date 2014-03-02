Installation
============

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