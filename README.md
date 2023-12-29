# Tp_PHP

Pour lancer le projet sour laravel 

Se Mettre a la racine du dossier RestApi puis :

```bash
sudo apt install -y composer php-xml php-curl php-sqlite3
```
```bash
mv .env.exemple .env
```
```bash
composer i
```
```bash
php artisan migrate
```
```bash
php artisan serve 
```

## Voici les differentes routes

### Post

```
/api/createuser?name=NOM&email=EMAIL&password=PASSWORD 

/api/createhero?userId=ID&name=banos&secret_identity=guez&gender=Homme&hair_color=black&origin_planet=earth&description=il

api/createcity?name=test

api/creategroup?name=test

/api/createvehicule?name=test

/api/creategadget?name=test

/api/createsuperpower?name=test

/api/addpowerhero?superhero_id=ID&superpower_id=ID

/api/addcityhero?superhero_id=ID&city_id=ID

/api/addgadgethero?superhero_id=ID&gadget_id=ID

/api/addgrouphero?superhero_id=ID&group_id=ID

```

### Delete 
```http

/api/addpowerhero?superhero_id=ID&superpower_id=ID

/api/addcityhero?superhero_id=ID&city_id=ID

/api/addgadgethero?superhero_id=ID&gadget_id=ID

/api/addgrouphero?superhero_id=ID&group_id=ID

```

### Get 

#### Toutes la base de donnée

```http

/api/gethero

/api/getuser

/api/getcity

/api/getgroup

/api/getvehicule

/api/getgadget

/api/getsuperpower


```

#### Specifique au hero
```http

/api/addpowerhero?superhero_id=ID

/api/addcityhero?superhero_id=ID

/api/addgadgethero?superhero_id=ID

/api/addgrouphero?superhero_id=ID

```

## Documentation 

dans le path /doc 

```
Apres avoir faire la documentation dans le fichier faire :

-- php artisan l5-swagger:generate

puis lancer l'api en ligne

```




