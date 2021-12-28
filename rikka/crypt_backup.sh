#!/bin/sh

BACKUP_FILE_NAME="backup.dump"
/usr/bin/mysqldump --no-tablespaces --single-transaction -u ${DB_MIDAS_BACKUP_USER} -p${DB_MIDAS_BACKUP_PASS} -h ${DB_HOST} ${DB_DATABASE_NAME} > /tmp/${BACKUP_FILE_NAME}
gzip /tmp/${BACKUP_FILE_NAME}
BACKUP_GZIP_FILE_NAME=${BACKUP_FILE_NAME}.gz

openssl aes-256-cbc -e -pbkdf2 -iter 100000 -salt -in /tmp/${BACKUP_GZIP_FILE_NAME} -out /tmp/encrypted_${BACKUP_GZIP_FILE_NAME} -pass file:pass.txt

rm /tmp/${BACKUP_GZIP_FILE_NAME}

# BACKUP_FILE_NAME="backup$(date +\%Y\%m\%d\%H\%M\%S).dump"
# rm /tmp/encrypted_${BACKUP_GZIP_FILE_NAME}

