# API Platform Contract Backend

This package contains the backend part of a simple application for concluding remote work contracts, which is used daily in the creator's company.

# Installation

### Build docker containers:

```bash
$ docker compose up -d
```

### In the main application container, run the following commands:

```bash
$ php bin/console doctrine:migrations:migrate
$ php bin/console doctrine:fixtures:load
```

### In your favourite browser open [https://localhost/docs](https://localhost/docs)

### Obtain admin auth token running following command:

```bash
curl -X 'POST' \
  'https://localhost/auth' \
  -H 'accept: application/json' \
  -H 'Content-Type: application/json' \
  -d '{
  "username": "admin",
  "password": "password"
}'
```

### Go to [https://localhost/docs](https://localhost/docs) where you can browse individual API endpoints.

# Used software

![PHP](https://img.shields.io/badge/-PHP-000?logo=php&style=for-the-badge)
![POSTGRESQL](https://img.shields.io/badge/postgresql-4169e1?style=for-the-badge&logo=postgresql&logoColor=white)
![SYMFONY](https://img.shields.io/badge/-SYMFONY-000?logo=symfony&style=for-the-badge)
![API PLATFORM](https://img.shields.io/badge/-API%20PLATFORM-000?logo=symfony&style=for-the-badge)
![PHP UNIT](https://img.shields.io/badge/-PHPUNIT-000?logo=php&style=for-the-badge)
![DOCKER](https://img.shields.io/badge/-DOCKER-000?&logo=docker&style=for-the-badge)
![COMPOSER](https://img.shields.io/badge/-COMPOSER-000?&logo=composer&style=for-the-badge)

