# REST API With Slim3 PHP Framework

## Installation

**Step 1** - Clone this repo to desired location
```bash
$ git clone https://github.com/AnechaS/slim-rest-api.git
```

**Step 2** - Change directory to newly cloned repo via CLI `cd /new/cloned/location`

**Step 3** - Load vendor
```bash
$ composer update
```

## Configuration

## Run Application

### With PHP Cli
```bash
$ php -S localhost:8080 -t public public/index.php
```

### With Composer
```bash
$ composer start
```

### With Docker

```bash
$ docker-compose up -d
```

load vendor with container

```bash
$ docker-compose exec php bash
$ composer update
```
