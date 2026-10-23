FROM php:8.2-apache

# Instalar extensiones de base de datos MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copiar el contenido de la carpeta src al directorio público de Apache
COPY src/ /var/www/html/

# Habilitar mod_rewrite de Apache para URLs amigables
RUN a2enmod rewrite

# Exponer el puerto web 80
EXPOSE 80