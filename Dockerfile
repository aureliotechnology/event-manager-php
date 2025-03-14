# Dockerfile

# Use a imagem oficial do PHP 8.2 com FPM
FROM php:8.2-fpm

# Instala dependências do sistema e extensões do PHP necessárias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# Instala o Composer (utilizando a imagem oficial do Composer)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www

# Copia o código da aplicação para o container
COPY . /var/www

# Copia o script de entrypoint para o container
COPY entrypoint.sh /entrypoint.sh

# Adiciona permissão de execução ao entrypoint
RUN chmod +x /entrypoint.sh

# Instala as dependências do Composer
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Ajusta as permissões para o usuário do PHP
RUN chown -R www-data:www-data /var/www

# Exponha a porta do PHP-FPM
EXPOSE 9000

# Define o entrypoint e o comando padrão
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]
