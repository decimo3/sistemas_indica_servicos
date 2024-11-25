FROM postgres:16

ENV POSTGRES_USER=${POSTGRES_USER}
ENV POSTGRES_DB=${POSTGRES_DB}

COPY database.sql database.sql

RUN psql -U $POSTGRES_USER -d $POSTGRES_DB -a -f database.sql

