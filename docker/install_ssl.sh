# shellcheck disable=SC2046
# shellcheck disable=SC2164
cd $(dirname "$0")/../
# shellcheck disable=SC2196
export $(egrep -v '^#' .env | xargs)

snap install --classic certbot
ln -s /snap/bin/certbot /usr/bin/certbot
certbot certonly --standalone -d "$APP_HOST_NAME"