FROM ubuntu:14.04

RUN apt-get update \
 && apt-get install -y nginx git make curl php5-cli\
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*
 
COPY nginx.conf /etc/nginx/nginx.conf

RUN  git clone https://github.com/AKSW/OntoWiki.git /var/www/ontowiki 
RUN cd /var/www/ontowiki && make deploy && cp config.ini.dist config.ini


EXPOSE 8080

CMD ["nginx", "-g", "daemon off;"]
