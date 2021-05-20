FROM httpd:latest

#RUN echo "IncludeOptional conf/sites/*.conf" >> /usr/local/apache2/conf/httpd.conf
RUN apt-get update
RUN apt-get install -y gettext-base

COPY httpd.conf /usr/local/apache2/conf/httpd.conf
COPY wikibase.conf.template /wikibase.conf.template
COPY entrypoint.sh /entrypoint.sh
#ENTRYPOINT ["httpd", "-D", "FOREGROUND"]
CMD ["/entrypoint.sh"]