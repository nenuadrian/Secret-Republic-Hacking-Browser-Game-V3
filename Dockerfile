FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    unzip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    default-mysql-client \
    libsqlite3-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql pdo_sqlite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/app

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --prefer-dist --no-interaction --no-progress --no-dev

# Create required directories for Smarty and ensure www-data can write
RUN mkdir -p includes/templates_c includes/cache \
    && chown -R www-data:www-data includes/templates_c includes/cache includes/

# Configure Nginx — rewrite mirrors what .htaccess does for Apache FPM:
#   RewriteRule ^(.*)$ index.php?/$1 [QSA,L]
RUN rm /etc/nginx/sites-enabled/default
COPY <<'NGINX_CONF' /etc/nginx/sites-enabled/default
server {
    listen 80;
    server_name _;
    root /var/www/app/public_html;
    index index.php;

    autoindex off;

    # Block access to hidden files and includes directory
    location ~ /\.(ht|git) {
        deny all;
    }

    location ^~ /includes/ {
        deny all;
    }

    # Serve static files directly, otherwise rewrite to index.php
    location / {
        try_files $uri $uri/ @rewrite;
    }

    location @rewrite {
        rewrite ^/(.*)$ /index.php?/$1 last;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
NGINX_CONF

# Configure Supervisor to run both Nginx and PHP-FPM
COPY <<'SUPERVISOR_CONF' /etc/supervisor/conf.d/app.conf
[supervisord]
nodaemon=true

[program:php-fpm]
command=php-fpm --nodaemonize
autostart=true
autorestart=true
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0

[program:nginx]
command=nginx -g "daemon off;"
autostart=true
autorestart=true
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0
SUPERVISOR_CONF

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
