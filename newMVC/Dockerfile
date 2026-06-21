FROM php:8.2-apache

# Installation des extensions nécessaires pour MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Activation du module rewrite d'Apache (souvent utile pour le MVC)
RUN a2enmod rewrite

# Augmentation de la taille du formulaire
RUN echo "upload_max_filesize=32M" >> /usr/local/etc/php/conf.d/uploads.ini \
 && echo "post_max_size=32M" >> /usr/local/etc/php/conf.d/uploads.ini

# On redémarre Apache pour appliquer
RUN service apache2 restart