FROM alpine:3.5
LABEL Maintainer="Florian Kroeber <fk@mxu.de>" \
      Description="Lightweight container with Nginx 1.10 & PHP-FPM 7.0 based on Alpine Linux."

# Install packages
RUN apk add --update \
--repository http://dl-cdn.alpinelinux.org/alpine/v3.5/main \
--repository http://dl-cdn.alpinelinux.org/alpine/v3.5/community \
--no-cache php7 php7-dev php7-session php7-fpm php7-sockets php7-xdebug php7-xml php7-json nginx supervisor freetds-dev php7-pdo_dblib



# volumes
#VOLUME ["/etc/nginx", "/etc/php7/php-fpm.d", "/etc/supervisor/conf.d"]
VOLUME ["/var/www/html"]

# Configure nginx
COPY config/default.conf /etc/nginx/conf.d/default.conf
COPY config/nginx.conf /etc/nginx/nginx.conf

# Configure PHP-FPM
COPY config/fpm-pool.conf /etc/php7/php-fpm.d/zzz_custom.conf
COPY config/php.ini /etc/php7/conf.d/zzz_custom.ini
COPY config/xdebug.ini /etc/php7/conf.d/xdebug.ini


# Configure supervisord
COPY config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Add application
RUN mkdir -p /var/www/html
WORKDIR /var/www/html


COPY src/ /var/www/html/

#TODO: Talk with TE whether GOCD can replace this during continous deployment
#ENV DEV=1

EXPOSE 8080
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
