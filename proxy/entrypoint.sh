#!/bin/sh

envsubst < /wikibase.conf.template > /wikibase.conf

if [ -z "$(ls -A /usr/local/apache2/conf/sites)" ]; then 
	cp /wikibase.conf /usr/local/apache2/conf/sites/ ; 
fi

httpd -D FOREGROUND

