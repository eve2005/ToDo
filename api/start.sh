
echo "Configurando o arquivo .env..."
cp .env.example .env
php artisan key:generate

cat <<EOF > /api/.env

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=ToDo
DB_USERNAME=root
DB_PASSWORD=root

EOF

echo "aguardando banco de dados"
while ! php artisan db:monitor > /dev/null 2>&1; do
  sleep 2
done
echo "rodando as migracoes"
php artisan migrate --force


php artisan serve --host=0.0.0.0 --port=8000