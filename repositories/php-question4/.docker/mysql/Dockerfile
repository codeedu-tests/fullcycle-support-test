FROM mysql:5.7 as builder

RUN usermod -u 1000 mysql

#ADD initdb.sql /docker-entrypoint-initdb.d/
COPY initdb.sql /docker-entrypoint-initdb.d/

RUN chmod -R 777 /docker-entrypoint-initdb.d

