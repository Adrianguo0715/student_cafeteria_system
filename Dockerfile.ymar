# 使用 PHP 和 Apache 的官方映像
FROM php:8.1-apache

# 複製專案檔案到容器內部
COPY ./ /var/www/html/

# 啟用必要的 Apache 模組
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN a2enmod rewrite

# 設定容器的工作目錄
WORKDIR /var/www/html

# 替換權限，確保可以正確執行
RUN chown -R www-data:www-data /var/www/html
