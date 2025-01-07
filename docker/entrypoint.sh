#!/bin/sh

# Terminate execution if any command fails
set -e

echo "*** Initializing the container"
cd /app

if [ ! -d "/app/runtime" ]; then
    mkdir -m 777 /app/runtime
    chown www-data /app/runtime
    mkdir -m 777 /app/runtime/cache
    chown www-data /app/runtime/cache
    mkdir -m 777 /app/runtime/logs
    chown www-data /app/runtime/logs
    mkdir -m 777 /app/runtime/mdx-cache
    chown www-data /app/runtime/mdx-cache
    mkdir -m 777 /app/runtime/saml
    chown www-data /app/runtime/saml
fi
touch /app/runtime/logs/app.log
chown www-data /app/runtime/logs/app.log

if [ ! -d "/app/www/assets/cache" ]; then
    mkdir -m 777 /app/www/assets/cache
fi

if [ "$SAML_SECRET_SALT" = "" ]; then
  # create and reuse a random SALT in a runtime file
  if [ ! -e /app/runtime/saml/salt ]; then
    echo "Generating SAML_SECRET_SALT"
    SALT=$(tr -dc A-Za-z0-9 < /dev/urandom | head -c32);
    echo "$SALT" >> /app/runtime/saml/salt;
    echo "SALT is $(cat /app/runtime/saml/salt)"
  else
    echo "Reading generated SAML_SECRET_SALT"
    SALT="$(head -1 </app/runtime/saml/salt)"
  fi
  export SAML_SECRET_SALT="$SALT"
fi

# Initialize database and apply migrations if any
php app migrate confirm=yes

if [ "$HTTPS_PORT" != "" ]; then
  a2ensite https
fi

if [ "$APPLICATION_ENV" = "production" ]; then
  cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
else
  cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini
  sed -i -e 's/^error_reporting = E_ALL.*$/error_reporting = E_ALL \& ~E_NOTICE \& ~E_DEPRECATED \& ~E_STRICT/' /usr/local/etc/php/php.ini
  sed -i -e 's/^display_errors = On.*$/display_errors = Off/' /usr/local/etc/php/php.ini
fi

php /app/docker/post-install.php
echo "*** starting apache"
exec apache2-foreground
