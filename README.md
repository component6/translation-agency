# Оглавление

- [Настройка переменных окружения](#настройка-переменных-окружения)
- [Установка приложения](#установка-приложения)
- [Установка и сборка npm](#установка-и-сборка-npm)
- [Заполнение БД тестовыми данными](#заполнение-бд-тестовыми-данными)
- [Доступные сервисы](#доступные-сервисы)


# Настройка переменных окружения

#### 1. Копируем файл `.env.example` и переименовываем его в `.env`.

###### Пример файла `.env`:
```
MYSQL_HOST=mysql
MYSQL_DATABASE=yii2advanced
MYSQL_USER=yii2advanced
MYSQL_PASSWORD=secret
MYSQL_ROOT_PASSWORD=verysecret

VITE_DEV_SERVER=http://192.168.0.103:5173
```

#### 2. Копируем файл `backend/vite/.env.example` и переименовываем его в `backend/vite/.env`.

###### Пример файла `backend/vite/.env`:
```
BACKEND_APP_URL=http://localhost:21080
VITE_APP_URL="${BACKEND_APP_URL}"
```



# Установка приложения

#### 1. Установка зависимостей приложения
```
docker-compose run --rm backend composer install
```
###### описание:
- run: создает новый контейнер и выполняет указанную команду внутри него.
- --rm: удаляет контейнер автоматически после завершения его работы.
- backend: название сервиса, определенного в файле docker-compose.yml.
- composer install: команда для установки зависимостей.

#### 2. Инициализация приложения
```
docker-compose run --rm backend php /app/init
```

#### 3. Создание и запуск контейнеров
```
docker-compose up -d
```

###### описание:
- up: создает и запускает контейнеры, службы и сети, определенные в вашем docker-compose.yml.
- -d: позволяет запускать контейнеры в фоновом режиме.

#### 4. Редактирование конфигурации компонента db
Откройте файл `common/config/main-local.php` и отредактируйте конфигурацию компонента `db`:
```
<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

return [
    ...
    'components' => [
        ...
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => "mysql:host=" . $_ENV['MYSQL_HOST'] . ";dbname=" . $_ENV['MYSQL_DATABASE'] . ";charset=utf8mb4",
            'username' => $_ENV['MYSQL_USER'],
            'password' => $_ENV['MYSQL_PASSWORD'],
            'charset' => 'utf8mb4',
        ],
        ...
    ],
];
```

#### 5. Запуск миграций
```
docker-compose run --rm backend yii migrate
```

###### Примечание:
На ОС Windows возможна ошибка при запуске команды миграций:
```
usermod: no changes
/usr/bin/env: 'php\r': No such file or directory    
```

Альтернативные варианты запуска миграций.

Используйте одну из команд:
- `docker-compose run --rm backend php yii migrate`
- `docker exec -it tra-age-backend php yii migrate`



# Установка и сборка npm

#### 1. Переходим в директорию `backend/vite`
```
cd backend/vite
```

#### 2. Установка npm зависимостей
```
npm install
```

#### 3. Сборка проекта
```
npm run build
```

#### 4. Запуск проекта в режиме разработки
```
npm run dev
```

###### Примечание:
После сборки проекта приложение доступно по адресу <a href="http://localhost:21080/app" target="_blank">http://localhost:21080/app</a>



# Заполнение БД тестовыми данными

#### 1. Создание пользователя
Используйте одну из команд:
- `docker-compose run --rm backend php yii admin/create`
- `docker exec -it tra-age-backend php yii admin/create`

###### Примечание:
- login: admin
- password: admin

#### 2. Заполнении других таблиц
Используйте одну из команд:
- `docker-compose run --rm backend php yii fill-test-data`
- `docker exec -it tra-age-backend php yii fill-test-data`



# Доступные сервисы

- <a href="http://localhost:21080" target="_blank">http://localhost:21080</a> - адрес бэкенд части приложения.
- <a href="http://localhost:20080" target="_blank">http://localhost:20080</a> - адрес фронтенд части приложения.
- <a href="http://localhost:8080" target="_blank">http://localhost:8080</a> - adminer для взаимодействия с БД.
