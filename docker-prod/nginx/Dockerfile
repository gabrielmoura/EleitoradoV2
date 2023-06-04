FROM nginx:1.25.0-alpine3.17-slim

LABEL maintainer="Gabriel Moura"

ARG WWWGROUP
WORKDIR /var/www/html/
# Configure nginx
COPY ./nginx.conf /etc/nginx/
COPY ./app-nginx.conf /etc/nginx/modules/


EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
