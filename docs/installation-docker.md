# Installation

## Requirements

docker + docker-compose

Installation instructions can be found here:
1. [Docker](https://docs.docker.com/engine/installation)
2. [Docker composer](https://docs.docker.com/compose/install)

## Let's begin

Before we can run application with docker we need to install composer dependencies.

```bash
docker run -v `pwd`:/var/www -w /var/www prooph/composer:7.1 install
```

After it ends we can run application with docker. First create a copy of `.env.dist`

```bash
cp .env.dist .env
```

If needed change values inside it and run application:

```bash
$ docker-compose up -d
```

## Open app

```
http://localhost:NGINX_PORT_FROM_.ENV_FILE
```
