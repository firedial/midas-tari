FROM alpine:3.13.2

RUN apk --update add tzdata && \
    cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime && \
    apk del tzdata && \
    rm -rf /var/cache/apk/* 

RUN apk add mariadb-dev && \
    apk add mariadb-client && \
    apk add curl && \
    apk add openssl

RUN adduser -D appuser
RUN mkdir /mnt/nas && \
    chown appuser:appuser /mnt/nas

USER appuser
WORKDIR /home/appuser

