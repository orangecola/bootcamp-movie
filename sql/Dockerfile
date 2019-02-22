FROM mysql:latest
ARG DBNAME 
ARG DBPASSWORD
ENV MYSQL_DATABASE=$DBNAME \
    MYSQL_ROOT_PASSWORD=$DBPASSWORD

RUN echo "default-authentication-plugin=mysql_native_password" >> /etc/mysql/my.cnf
ADD movie.sql /docker-entrypoint-initdb.d
