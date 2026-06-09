FROM php:8.4-apache

# Altera a pasta raiz do Apache para a pasta 'public'
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Ativa o mod_rewrite do Apache (necessário para .htaccess e rotas)
RUN a2enmod rewrite

# Instala as extensões de banco de dados
RUN docker-php-ext-install pdo pdo_mysql

# Copia o seu projeto para dentro do servidor
COPY . /var/www/html/