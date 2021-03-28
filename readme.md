# Laravel Reflection

Generate database
```
php artisan migrate:refresh --seed
```

Host locally
```
php artisan serve
```

Access at http://localhost:8000/

## Example user accounts
* `admin@example.com` `password` - Full rights.
* `manager@example.com` `password` - Create, view, edit, delete employees. Can view companies.
* `accountant@example.com` `password`- Only view.

## SQlite CLI

powershell:
```
& 'C:\Program Files\sqlite3\sqlite3.exe' database\database.sqlite
```

Make the output more human-readable:
```
.mode column
.headers on
```
