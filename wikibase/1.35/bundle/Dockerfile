FROM ubuntu:xenial as fetcher

RUN apt-get update && \
    apt-get install --yes --no-install-recommends unzip=6.* jq=1.* curl=7.* ca-certificates=201* && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

COPY download-extension.sh .
ADD https://github.com/wikidata/WikibaseImport/archive/master.tar.gz /WikibaseImport.tar.gz
RUN bash download-extension.sh OAuth;\
bash download-extension.sh Elastica;\
bash download-extension.sh CirrusSearch;\
bash download-extension.sh WikibaseCirrusSearch;\
bash download-extension.sh UniversalLanguageSelector;\
bash download-extension.sh cldr;\
bash download-extension.sh EntitySchema;\
bash download-extension.sh Scribunto;\
bash download-extension.sh ParserFunctions;\
bash download-extension.sh SyntaxHighlight_GeSHi;\
bash download-extension.sh TemplateData;\
bash download-extension.sh TemplateStyles;\
tar xzf OAuth.tar.gz;\
tar xzf Elastica.tar.gz;\
tar xzf CirrusSearch.tar.gz;\
tar xzf WikibaseCirrusSearch.tar.gz;\
tar xzf UniversalLanguageSelector.tar.gz;\
tar xzf cldr.tar.gz;\
tar xzf WikibaseImport.tar.gz;\
tar xzf EntitySchema.tar.gz;\
tar xzf Scribunto.tar.gz;\
tar xzf ParserFunctions.tar.gz;\
tar xzf SyntaxHighlight_GeSHi.tar.gz;\
tar xzf TemplateData.tar.gz;\
tar xzf TemplateStyles.tar.gz;\
rm ./*.tar.gz

FROM wikibase/wikibase:1.35 as collector
COPY --from=fetcher /WikibaseImport-master /var/www/html/extensions/WikibaseImport
COPY --from=fetcher /Elastica /var/www/html/extensions/Elastica
COPY --from=fetcher /OAuth /var/www/html/extensions/OAuth
COPY --from=fetcher /CirrusSearch /var/www/html/extensions/CirrusSearch
COPY --from=fetcher /WikibaseCirrusSearch /var/www/html/extensions/WikibaseCirrusSearch
COPY --from=fetcher /UniversalLanguageSelector /var/www/html/extensions/UniversalLanguageSelector
COPY --from=fetcher /cldr /var/www/html/extensions/cldr
COPY --from=fetcher /EntitySchema /var/www/html/extensions/EntitySchema
COPY --from=fetcher /Scribunto /var/www/html/extensions/Scribunto
COPY --from=fetcher /ParserFunctions /var/www/html/extensions/ParserFunctions
COPY --from=fetcher /SyntaxHighlight_GeSHi /var/www/html/extensions/SyntaxHighlight_GeSHi
COPY --from=fetcher /TemplateData /var/www/html/extensions/TemplateData
COPY --from=fetcher /TemplateStyles /var/www/html/extensions/TemplateStyles

FROM composer@sha256:d374b2e1f715621e9d9929575d6b35b11cf4a6dc237d4a08f2e6d1611f534675 as composer
COPY --from=collector /var/www/html /var/www/html
WORKDIR /var/www/html/
RUN rm /var/www/html/composer.lock
RUN composer install --no-dev

FROM wikibase/wikibase:1.35

RUN apt-get update && \
    apt-get install --yes --no-install-recommends jq=1.* && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer /var/www/html /var/www/html
COPY LocalSettings.php.wikibase-bundle.template /LocalSettings.php.wikibase-bundle.template
COPY extra-install.sh /
COPY extra-entrypoint-run-first.sh /
RUN cat /LocalSettings.php.wikibase-bundle.template >> /LocalSettings.php.template && rm /LocalSettings.php.wikibase-bundle.template
RUN mkdir /var/www/html/config
COPY oauth.ini /templates/oauth.ini
COPY wiki-import.xml.template /
COPY Wikidata-Useful_Templates.xml /
