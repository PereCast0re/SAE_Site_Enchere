FROM php:8.2-apache

# Installation des extensions nécessaires pour MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Activation du module rewrite d'Apache (souvent utile pour le MVC)
RUN a2enmod rewrite

# On redémarre Apache pour appliquer
RUN service apache2 restart