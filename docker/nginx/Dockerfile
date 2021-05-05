FROM nginx:1.15.3-alpine

RUN rm /etc/nginx/conf.d/default.conf
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

COPY public /usr/src/app/public

WORKDIR /usr/src/app