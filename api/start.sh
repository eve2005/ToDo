echo "aguardando banco de dados"
while ! php artisan db:monitor > /dev/null 2>&1; do
  sleep 2
done

echo "rodando as migracoes"
php artisan migrate --force

echo "iniciando o servidor..."
cp .env.example .env
php artisan key:generate

echo "Configurando o arquivo .env..."
cat <<EOF > /api/.env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=ToDo
DB_USERNAME=root
DB_PASSWORD=root

CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
EOF

php artisan serve --host=0.0.0.0 --port=8000