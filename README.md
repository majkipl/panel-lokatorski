# Panel lokatorski - Laravel 11

## Wprowadzenie

Projekt w Laravel 11 - panel zarządzania wspólnymi wydatkami.

## Wymagania

- Docker
- Docker Compose
- PHP >= 8.0
- Composer
- Laravel 11
- Baza danych MySQL

## Instalacja

1. Sklonuj repozytorium:

```

```

2. Przejdź do katalogu projektu:

```
cd twoj_projekt
```

3. Zbuduj i uruchom kontenery Docker'a:

```
docker-compose up -d --build
```

4. Zainstaluj zależności za pomocą composera:

```
composer install
```

5. Skopiuj plik `.env.example` do `.env` i skonfiguruj swoje ustawienia środowiska:

```
cp .env.example .env
```

6. Wygeneruj klucz aplikacji:

```
php artisan key:generate
```

7. Uruchom migracje i seedery bazy danych:

```
php artisan migrate --seed
```



