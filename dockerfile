# Utilisation d'une image PHP avec Apache préinstallé
FROM php:8.1-apache

# Installation des dépendances nécessaires
RUN apt-get update && apt-get install -y     git     libzip-dev     zip     unzip

# Activation des modules Apache nécessaires pour Laravel
RUN a2enmod rewrite

# Configuration du répertoire de travail
WORKDIR /var/www/html

# Clonage du référentiel GitHub
RUN git clone https://github.com/GnsiXenon/Tp_PHP RestApi

# Copie du fichier .env dans le projet Laravel
COPY .env /var/www/html/RestApi/RestApi/.env

# Installation des dépendances PHP via Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN cd RestApi/RestApi && composer install
RUN composer require darkaonline/l5-swagger
# Configuration des permissions
RUN chown -R www-data:www-data /var/www/html/RestApi/RestApi/storage

# Configuration du document root Apache
RUN sed -i -e 'svar/www/html/RestApi/RestApi/publicgo run main.go' /etc/apache2/sites-available/000-default.conf

# Exposition du port 80
EXPOSE 80

# Commande par défaut pour exécuter Apache en arrière-plan
CMD [apache2-foreground]

