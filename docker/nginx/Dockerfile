FROM nginx:1.22-alpine

RUN deluser nginx && adduser -DH -h /home/nginx -s /sbin/nologin -u 1000 nginx

COPY nginx.conf /etc/nginx/nginx.conf
COPY host.conf /etc/nginx/host.conf
RUN rm -rf /var/www/html

WORKDIR /var/www/public
