# shellcheck disable=SC2046
# shellcheck disable=SC2164
cd $(dirname "$0")
# shellcheck disable=SC2046
# shellcheck disable=SC2196
export $(egrep -v '^#' .env | xargs)

docker-compose up -d
docker-compose exec php composer install
docker-compose exec db mysql -v -u "$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE" < .docker_data/backup/dump.sql
docker-compose exec db mysql -v \
--execute="update wp_options set option_value = \"https://$APP_HOST_NAME/\" where option_name=\"siteurl\";" \
--execute="update wp_options set option_value = \"https://$APP_HOST_NAME\" where option_name=\"home\";" \
-u "$MYSQL_USER" \
-p"$MYSQL_PASSWORD" \
"$MYSQL_DATABASE"