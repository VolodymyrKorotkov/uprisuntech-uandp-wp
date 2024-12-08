# Використовуємо офіційний образ PHP з Apache для запуску WordPress
FROM php:7.4-apache

# Встановлюємо деякі додаткові залежності
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    unzip \
    wget

# Включаємо та налаштовуємо модулі Apache
RUN a2enmod rewrite
RUN a2enmod expires

# Встановлюємо та налаштовуємо PHP-розширення
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd mysqli pdo_mysql zip

# Копіюємо весь вміст каталогу WordPress в образ
COPY . /var/www/html

# Створюємо том для зберігання даних uploads
VOLUME /var/www/html/wp-content/uploads

# Встановлюємо права доступу для кореневого каталогу WordPress
RUN chown -R www-data:www-data /var/www/html

# Вказуємо деякі конфігураційні налаштування для Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Відкриваємо порт Apache
EXPOSE 80

# Запускаємо Apache при старті контейнера
CMD ["apache2-foreground"]