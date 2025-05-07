# 📦 Telegram Notify Bot

Сервис на Laravel 11 для отправки уведомлений пользователям через Telegram-бота, используя задачи из внешнего API.

## 🚀 Возможности

### 📬 Команды Telegram-бота:
- `/start` — подписка на уведомления
- `/stop` — отписка

### 🔁 Загрузка задач с внешнего API:
- https://jsonplaceholder.typicode.com/todos

### 🔔 Рассылка задач активным пользователям через очередь:
- Jobs + database queue

### 🌐 Telegram Webhook:
- Без SDK, через Guzzle HTTP Client

## ⚙️ Технологии

- Laravel 11
- PHP 8.2+
- MySQL
- Laravel HTTP (Guzzle)
- Telegram Bot API (напрямую)
- Laravel Queues (с `database` драйвером)

---

## 📁 Установка

```bash
git clone https://github.com/yalasev903/telegram_notify_bot.git
cd telegram_notify_bot
composer install
cp .env.example .env
php artisan key:generate
🧙‍♂️ Настройка .env
dotenv

APP_URL=http://localhost:8000
TELEGRAM_BOT_TOKEN=ваш_токен_бота

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=telegram_notify_bot
DB_USERNAME=root
DB_PASSWORD=your_password

QUEUE_CONNECTION=database
🛠️ Запуск локально

php artisan migrate
php artisan queue:table
php artisan migrate
php artisan serve
🌍 Открытие порта в интернет через localhost.run

ssh -R 80:localhost:8000 ssh.localhost.run
🤖 Установка webhook

php artisan webhook:set
📬 Команды Telegram
/start — добавляет или активирует пользователя

/stop — отключает подписку (subscribed = false)

🔄 Ручная отправка задач

php artisan notify:tasks
✅ Пример сообщения пользователю:
diff

Новые задачи:
- delectus aut autem
- quis ut nam facilis et officia qui
- fugiat veniam minus
...
🧪 Тестирование

php artisan test
Проверяется:

/start — пользователь сохраняется

/stop — отключается подписка

notify:tasks — рассылает задачи подписанным пользователям

📬 Postman коллекция
Сохраните следующий JSON в файл postman_collection.json и импортируйте в Postman:

json

{
  "info": {
    "_postman_id": "telegram-bot-webhook",
    "name": "Telegram Notify Bot",
    "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
  },
  "item": [
    {
      "name": "/api/webhook (POST)",
      "request": {
        "method": "POST",
        "header": [
          {
            "key": "Content-Type",
            "value": "application/json"
          }
        ],
        "body": {
          "mode": "raw",
          "raw": "{\n  \"message\": {\n    \"chat\": {\n      \"id\": 123456789,\n      \"first_name\": \"TestUser\"\n    },\n    \"text\": \"/start\"\n  }\n}"
        },
        "url": {
          "raw": "{{base_url}}/api/webhook",
          "host": ["{{base_url}}"],
          "path": ["api", "webhook"]
        }
      },
      "response": []
    }
  ],
  "variable": [
    {
      "key": "base_url",
      "value": "http://localhost:8000"
    }
  ]
}


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development/)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
