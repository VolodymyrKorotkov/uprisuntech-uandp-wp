# shellcheck disable=SC2046
# shellcheck disable=SC2164
cd $(dirname "$0")/../
# shellcheck disable=SC2046
# shellcheck disable=SC2196
export $(egrep -v '^#' .env | xargs)

docker-compose exec -T db mysqldump -v -u "$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE"