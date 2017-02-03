clab2-golapi
------------

A Clab2 framework alá készült az élet játék üzleti logikáját tartalmazó
modul. Az interface-ek által leírt objektumok különböző implementáció
közül a konfigurációs állományban lehet kiválasztani az adatok 
tárolásának módját és a játékszabályokat.

A csomagban elérhető implementációk:

Játékszabályok:
- Rule\Conway: klasszikus életjátékszabályok

Adatbázis modelek
- Doctrine\Odm: mongo adatbázismodel, doctrine implementációval

A fejlesztéshez szükséges csomagok telepítése:

    composer install

A REST API swagger dokumentációjának generálása:

    php doc.php

A csomag tesztelése:

    phpunit --configuration phpunit.xml

A tesztek konfigurációja, ha szükséges, lokálisan módosítható. Ehhez
létre kell hozni egy environment.php állományt a teszt könyvtár alatt. 
Ebben módosítható a teszt alap konfigurációja, pl. átírható az sql
adatbázis jelszava:

```php
return [
    'application' => [
        'business' => [
            'sql' => [
                'password' => 'sajátjelszavam'
            ]
        ]
    ]
];
```

