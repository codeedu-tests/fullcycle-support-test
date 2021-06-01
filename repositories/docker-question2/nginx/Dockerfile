FROM nginx:1.15.0-alpine

COPY ./index.html /usr/share/nginx/html
COPY ./default.conf /etc/nginx/conf.d

CMD ["nginx", "-g", "daemon off;"]