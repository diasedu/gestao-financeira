FROM php:8.4-apache

# Altera a pasta raiz do Apache para a pasta 'public'
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Ativa o mod_rewrite do Apache (necessário para rotas/.htaccess)
RUN a2enmod rewrite

# Instala extensões de banco de dados e ferramentas necessárias (zip/unzip)
RUN apt-get update && apt-get install -y libzip-dev zip unzip \
    && docker-php-ext-install pdo pdo_mysql zip

# Copia o Composer oficial para dentro do nosso servidor
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia os arquivos do projeto para o servidor
COPY . /var/www/html/

# Entra na pasta do projeto e roda o Composer para instalar as dependências
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Ajusta as permissões para o Apache conseguir ler os arquivos
RUN chown -R www-data:www-data /var/www/html