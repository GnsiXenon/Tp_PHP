# Tp_PHP


Pour lancer le projet sour laravel 

Se Mettre a la racine du dossier RestApi puis :

```
sudo apt install composer

sudo apt-get install php-xml

sudo apt-get install php-curl


mv .env.exemple .env 

composer install 

sudo apt-get install php-sqlite3

php artisant migrate 

php artisant serve 


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





