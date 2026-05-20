# Деплой Autoclub на Railway

Проект: **Laravel 13**, нужен **PHP 8.3+**. Railway обычно сам определяет Laravel и запускает через PHP + веб-сервер (Nixpacks/Railpack).

В корне репозитория уже есть **`nixpacks.toml`** — в сборке явно используются **PHP 8.4** и **Composer** (как в стандартной инструкции для Nixpacks).

## 1. Пока идёт деплой — переменные

В проекте **autoclub** → вкладка **Variables** добавьте:

```env
APP_ENV=production
APP_DEBUG=false
LOG_CHANNEL=stderr
```

## 2. APP_KEY

Локально в папке проекта (PowerShell):

```powershell
php artisan key:generate --show
```

Скопируйте строку вида `base64:...` и в Railway добавьте:

```env
APP_KEY=base64:xxxxxxxxxxxxxxxx
```

(подставьте свой ключ целиком)

## 3. База данных (обязательно для продакшена)

На Railway **SQLite не подходит** — диск временный, данные пропадут после перезапуска.

1. На canvas проекта: **+ New** → **Database** → **MySQL** (или PostgreSQL).
2. В сервисе приложения **Variables** добавьте (для MySQL):

```env
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
```

Имена `MySQL.*` должны совпадать с именем вашего сервиса БД в Railway (если сервис называется иначе — подставьте его имя в шаблоне переменных).

3. В **Deploy** → **Pre-deploy command** (или один раз локально к БД на Railway):

```bash
php artisan migrate --force
```

При первом деплое можно добавить сиды (по желанию):

```bash
php artisan migrate --force && php artisan db:seed --force
```

## 4. URL сайта

После **Generate Domain** (Settings → Networking):

```env
APP_URL=https://autoclub-production.up.railway.app
```

Подставьте **ваш** домен из Railway (с `https://`).

## 5. Когда deploy закончится

**Settings** → **Networking** → **Generate Domain** — появится ссылка вида:

`https://ваш-проект.up.railway.app`

## 6. Если deploy падает

Пришлите **Build Logs** или **Deploy Logs**. Частые причины:

| Проблема | Что сделать |
|----------|-------------|
| Нет `APP_KEY` | Сгенерировать и добавить в Variables |
| PHP слишком старый | В настройках сервиса указать PHP **8.3+** |
| Ошибка БД | Подключить MySQL и переменные `DB_*` |
| 500 после деплоя | Проверить `APP_URL`, миграции, логи (`LOG_CHANNEL=stderr`) |

## 7. Репозиторий на GitHub

Railway деплоит из Git. В репозиторий **не** попадают `.env` и `vendor` — на сервере при сборке выполняется `composer install`.

Убедитесь, что в GitHub залиты последние коммиты (в т.ч. обновлённый `public/index.php`, если нужен shared hosting локально — на Railway это не требуется).

## Минимальный чеклист Variables

```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:...
APP_URL=https://ваш-домен.up.railway.app
LOG_CHANNEL=stderr

DB_CONNECTION=mysql
DB_HOST=...
DB_PORT=3306
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```
