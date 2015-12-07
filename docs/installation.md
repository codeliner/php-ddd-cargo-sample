# Installation

## Using Git and Composer (recommended)

Clone the repository and manually invoke `composer` using the shipped
`composer.phar`:

    cd my/www/dir
    git clone https://github.com/prooph/php-ddd-cargo-sample.git
    cd php-ddd-cargo-sample
    php composer.phar self-update
    php composer.phar install

(The `self-update` directive is to ensure you have an up-to-date `composer.phar`
available.)

## Setup a Database

Our sample works with a MySql database so you need a running MySql Server and an
empty test database called `cargo_sample`.

The cargo sample ships with [doctrine/migrations](https://github.com/doctrine/migrations) to create the schema. But before we can run the migrations we
need to configure a database connection.

Copy and rename the [config/autoload/local.php.dist](https://github.com/prooph/php-ddd-cargo-sample/blob/master/config/autoload/local.php.dist) to `local.php`
and fill in your database credentials.

Now run `php bin/migrations.php migrations:migrate` in a terminal (Command must be invoked in project root)

## Web Server Setup

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

### nginx & php-fpm

    server {

        root /path/to/php-ddd-cargo-sample/public;
        index index.html index.htm index.php;

        server_name cargo-sample.localhost;

        location / {
            try_files $uri $uri/ /index.php$is_args$args;
        }

        location ~ .*\.(php|phtml)?$ {
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_param APPLICATION_ENV development;
            fastcgi_pass unix:/var/run/php5-fpm.sock;
            fastcgi_index index.php;
        }

        location ~ .*\.(git|jpg|jpeg|png|bmp|swf|ico)?$ {
            expires 30d;
        }

        location ~ .*\.(js|css)?$ {
            expires 1h;
        }

        location ~ /\.ht {
            deny all;
        }
    }

### PHP Build-In Webserver

Run `php -S 0.0.0.0:8080 -t public/ # then browse to http://localhost:8080/`


## Permissions

The application needs write access for the `data/` dir and all sub folders.