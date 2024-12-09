# 使用官方 PHP 映像
FROM php:8.1-apache

# 將專案檔案複製到容器中
COPY . /var/www/html/

# 確保必要的 PHP 擴展已安裝
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 設定 Apache Document Root
WORKDIR /var/www/html

# 曝露 80 埠給外部訪問
EXPOSE 80
