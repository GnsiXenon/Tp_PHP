FROM tomyj/my-env
ENV DEBIAN_FRONTEND noninteractive
ENV DEBCONF_NONINTERACTIVE_SEEN true
WORKDIR /app
RUN apt update -y && apt full-upgrade -y
RUN apt install -y composer php-xml php-curl php-sqlite3
COPY . .
RUN mv .env.exemple .env
RUN composer i
RUN php artisan migrate
CMD [ "php", "artisan", "serve", "--port", "8000", "--host", "0.0.0.0" ]