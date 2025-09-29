# Mini CRM (Laravel 12 + Blade)

## 🚀 Запуск проєкту

```bash
# 1. Клонувати репозиторій
git clone git@github.com:gdavenue/mini-crm.git
cd mini-crm

# 2. Встановити залежності
composer install
npm install && npm run build

# 3. Створити .env
cp .env.example .env
php artisan key:generate

# 4. Налаштувати підключення до БД у .env

# 5. Виконати міграції та сидери
php artisan migrate --seed

# 6. Створити симлінк для файлів
php artisan storage:link

# 7. Запустити сервер
composer run dev
```

## 🧑 Тестові дані

**Адмін:**

-   Email: `manager@example.com`
-   Пароль: `e9xfZ4X=5]Ep`

## 💬 Форма зворотного зв’язку

Форма доступна за адресою /feedback-widget.
Її можна вбудувати на сторонній сайт через iframe:

```html
<iframe
    src="http://localhost:8000/feedback-widget"
    style="width:100%;height:500px;border:0;"
></iframe>
```

## 🔑 API

### Створення заявки

`POST /api/tickets`\

> [!TIP]
> Поля: `name`, `phone`, `email`, `subject`, `body`, `file[]`

> [!IMPORTANT]
> Не більше однієї заявки на добу з однаковим email або телефоном.

### Статистика заявок

`GET /api/tickets/statistics`\

> [!NOTE]
> Повертає кількість заявок за добу, тиждень, місяць.

### Список заявок

`GET /api/tickets`\

> [!TIP]
> Фільтри: `date`, `status`, `email`, `phone`.

### Перегляд заявки

`GET /api/tickets/{id}`

### Зміна статусу заявки

`PATCH /api/tickets/{id}/status`
