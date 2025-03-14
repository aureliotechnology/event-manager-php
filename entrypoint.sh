#!/bin/sh
# Aguarda o banco de dados estar disponível (pode ajustar ou usar um script mais robusto)
sleep 10

# Executa as migrations automaticamente
php artisan migrate --force --no-interaction

# Inicia o processo principal do container
exec "$@"
