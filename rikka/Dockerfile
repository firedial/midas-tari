FROM alpine:3.13.2

RUN mkdir /mnt/nas

RUN apk --update add tzdata && \
    cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime && \
    apk del tzdata && \
    rm -rf /var/cache/apk/* 

RUN apk add mariadb-dev && \
    apk add mariadb-client 
RUN apk add curl
