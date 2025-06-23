FROM debian:latest
RUN apt update && apt install --yes apt-transport-https ca-certificates && apt update
RUN apt install apache2 net-tools --yes --fix-missing
RUN apt install php libapache2-mod-php php-pgsql --yes --fix-missing
RUN a2enmod php*
ENTRYPOINT ["apache2ctl", "-D", "FOREGROUND"]

