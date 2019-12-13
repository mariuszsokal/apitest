##Napisz listę kroków-komend konsolowych, które wykorzystałeś do przygotowania potrzebnej wersji aplikacji:
```
composer create-project symfony/skeleton apitest 4.4.*
cd apitest
composer require symfony/web-server-bundle --dev
composer require api
composer require symfony/maker-bundle --dev
php bin/console make:entity Student
php bin/console make:entity Tutor
php bin/console make:entity Grade
php bin/console make:entity Mark
php bin/console make:entity Subject
php bin/console doctrine:schema:create
php bin/console server:run
```
##Przygotuj listę requestów do API z parametrami potrzebną do wykonania operacji w pkt b)

### Dodawanie / usuwanie / modyfikacja danych ucznia.
**Dodawanie (POST)**
``/api/students``
```
{
    "name": "Testowy",
    "surname": "Uczen"
}
```

**Usuwanie (DELETE)**
``/api/students/{id}``

**Modyfikowanie (PATCH)**
``/api/students/{id}``
```
{
    "name": "Nowy"
}
```

### Dodawanie / usuwanie / modyfikacja danych nauczyciela.
**Dodawanie (POST)**
``/api/tutors``
```
{
    "name": "Testowy",
    "surname": "Nauczyciel"
}
```

**Usuwanie (DELETE)**
``/api/tutors/{id}``

**Modyfikowanie (PATCH)**
``/api/tutors/{id}``
```
{
    "name": "Nowy"
}
```

### Dodawanie / usuwanie / modyfikacja danych klasy.
**Dodawanie (POST)**
``/api/grades``
```
{
    "type": 0,
    "description": "1a"
}
```

**Usuwanie (DELETE)**
``/api/grades/{id}``

**Modyfikowanie (PATCH)**
``/api/grades/{id}``
```
{
    "description": "1b"
}
```

### Dodawanie / usuwanie / modyfikacja danych przedmiotu.
**Dodawanie (POST)**
``/api/subjects``
```
{
    "name": "Informatyka"
}
```

**Usuwanie (DELETE)**
``/api/subjects/{id}``

### Dodawanie ocen dla uczniów (z zaznaczeniem nauczyciela i przedmiotu) oraz ich usuwanie
**Dodawanie (POST)**
``/api/marks``

Zakładając, że zostały już dodane rekordy ze studentem i przedmiotem z ID 1
```
{
    "value": 5,
    "student": {"@id": "/api/students/1"},
    "subject": {"@id": "/api/subjects/1"}
}
```

**Usuwanie (DELETE)**
``/api/marks/{id}``

### Pobieranie listy uczniów dla danej klasy
**(GET)** ``/api/grades/{id}/students``

### Pobieranie listy uczniów, których uczy dany nauczyciel
**(GET)** ``/api/tutors/{id}/subject/students``

*Czas pracy: ~2h*