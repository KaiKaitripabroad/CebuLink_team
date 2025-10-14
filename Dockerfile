# 1️⃣ PHP + Apache をベースにする
FROM php:8.2-apache

# 2️⃣ 必要なパッケージと拡張機能をインストール
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 3️⃣ Composerをインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4️⃣ アプリをコンテナ内にコピー
WORKDIR /var/www/html
COPY . .

# 5️⃣ Laravel依存パッケージをインストール
RUN composer install --no-dev --optimize-autoloader

# 6️⃣ 権限を調整
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 7️⃣ Laravelのキーを自動生成
RUN php artisan key:generate

# 8️⃣ ApacheのDocumentRootを「public」に変更
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 9️⃣ Apacheをフォアグラウンドで起動
CMD ["apache2-foreground"]
