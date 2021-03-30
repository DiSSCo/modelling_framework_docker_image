#!/usr/bin/env bash

/wait-for-it.sh $MW_ELASTIC_HOST:$MW_ELASTIC_PORT -t 300

if [ ! -e "/var/www/html/LocalSettings.php" ]; then
       if [[ -f /var/www/html/config/LocalSettings.php ]]; then
               ln -s /var/www/html/config/LocalSettings.php /var/www/html/LocalSettings.php
       fi
fi

