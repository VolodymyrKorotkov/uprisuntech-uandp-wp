# shellcheck disable=SC2196
# shellcheck disable=SC2046
export $(egrep -v '^#' /var/www/html/.env | xargs)

envsubst < /var/www/html/docker/nginx/default.conf.template > /etc/nginx/conf.d/default.conf && \
nginx -g 'daemon off;'