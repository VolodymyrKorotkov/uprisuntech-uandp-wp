# shellcheck disable=SC2046
# shellcheck disable=SC2164
cd $(dirname "$0")/../
# shellcheck disable=SC2046
# shellcheck disable=SC2196
export $(egrep -v '^#' .env | xargs)

docker-compose exec -T db mysqldump -v --add-drop-table -u "$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE" > .docker_data/backup/db_backup_$(date '+%Y-%m-%d-%H-%M-%S').sql

#echo "create dump on remote server"
#docker-compose exec -T db mysqldump -v --add-drop-table -h  -u "$MYSQL_USER" -p"$MYSQL_ROOT_PASSWORD_STAGE" "$MYSQL_DATABASE" > .docker_data/backup/db_remote_backup.sql

#echo "Sync database"
#rsync -havuz "$1:/var/www/uandp-wp/docker/backup/db_tmp_backup.sql" docker/backup/db_remote_tmp_backup.sql
#
docker-compose exec -T db mysql -v -u "$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE" < .docker_data/backup/dump.sql