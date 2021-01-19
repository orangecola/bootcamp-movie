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
RUN a2enmod ssl headers
RUN apt-get update && \
    apt-get install -y openssl && \
    openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /root/bootcamp-movie.com.key \
    -out /root/bootcamp-movie.com.crt -subj "/C=SG/ST=Singapore/L=APAC/O=SEC Consult/OU=Boot camp/CN=bootcamp-movie.com"    
COPY headers.conf /etc/apache2/conf-enabled
COPY security.conf /etc/apache2/conf-enabled
COPY 001-ssl.conf /etc/apache2/sites-enabled
COPY php.ini /usr/local/etc/php/php.ini
COPY ./public_html /var/www/html
