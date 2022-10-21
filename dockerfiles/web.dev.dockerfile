FROM nginx:1.21

COPY docker-config/vhost.conf /etc/nginx/conf.d/default.conf
COPY docker-config/cert.crt /usr/nginx/keys/cert.crt
COPY docker-config/cert.key /usr/nginx/keys/cert.key

RUN ln -sf /dev/stdout /var/log/nginx/access.log \
	&& ln -sf /dev/stderr /var/log/nginx/error.log

