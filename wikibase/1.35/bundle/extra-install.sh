#!/bin/bash

php /var/www/html/extensions/CirrusSearch/maintenance/UpdateSearchIndexConfig.php
php /var/www/html/extensions/CirrusSearch/maintenance/ForceSearchIndex.php --skipParse
php /var/www/html/extensions/CirrusSearch/maintenance/ForceSearchIndex.php --skipLinks --indexOnSkip

n=0
until [ $n -ge 5 ]
do
   php /var/www/html/extensions/OAuth/maintenance/createOAuthConsumer.php --approve --callbackUrl  $QS_PUBLIC_SCHEME_HOST_AND_PORT/api.php \
	--callbackIsPrefix true --user $MW_ADMIN_NAME --name QuickStatements --description QuickStatements --version 1.0.1 \
	--grants createeditmovepage --grants editpage --grants highvolume --jsonOnSuccess > /quickstatements/data/qs-oauth.json && break
	n=$[$n+1]
	sleep 5s
done

if [[ -f /quickstatements/data/qs-oauth.json ]]; then
    export OAUTH_CONSUMER_KEY=$(jq -r '.key' /quickstatements/data/qs-oauth.json);
    export OAUTH_CONSUMER_SECRET=$(jq -r '.secret' /quickstatements/data/qs-oauth.json);
	envsubst < /templates/oauth.ini > /quickstatements/data/oauth.ini
fi

if [ ! -L  /var/www/html/LocalSettings.php ]; then
	mv /var/www/html/LocalSettings.php /var/www/html/config/LocalSettings.php
	ln -s /var/www/html/config/LocalSettings.php /var/www/html/LocalSettings.php
fi

page='Mediawiki:QueryTemplateImport'
version=$(php /var/www/html/maintenance/getText.php "$page" 2>&1 )  || :
if echo "$version" | fgrep -q "does not exist"; then
	envsubst < /wiki-import.xml.template > /wiki-import.xml
	php /var/www/html/maintenance/importDump.php < /wiki-import.xml
	sleep 2s
	php /var/www/html/maintenance/rebuildrecentchanges.php
fi
