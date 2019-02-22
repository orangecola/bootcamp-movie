from php:7.1-apache
RUN docker-php-ext-install pdo_mysql mysqli
RUN echo "log_errors = On" >> /usr/local/etc/php/php.ini
RUN echo "error_log = /dev/stderr" >> /usr/local/etc/php/php.ini
ARG DBHOST 
ARG DBUSERNAME 
ARG DBPASSWORD 
ARG DBNAME
ENV HOSTNAME=$DBHOST
ENV USERNAME=$DBUSERNAME
ENV PASSWORD=$DBPASSWORD
ENV DB_NAME=$DBNAME
COPY ./public_html /var/www/html
