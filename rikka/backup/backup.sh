#!/bin/sh

/usr/bin/mysqldump --no-tablespaces --single-transaction -u ${DB_MIDAS_BACKUP_USER} -p${DB_MIDAS_BACKUP_PASS} -h ${DB_HOST} ${DB_DATABASE_NAME} > /tmp/backup.dump
sshpass -p ${SSH_PASS} scp /tmp/backup.dump ${SSH_USER}@${SSH_HOST}:~/backup/backup$(date +\%Y\%m\%d\%H\%M\%S).dump
rm /tmp/backup.dump

