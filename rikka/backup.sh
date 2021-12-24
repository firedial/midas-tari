
/usr/bin/mysqldump --no-tablespaces --single-transaction -u ${DB_MIDAS_BACKUP_USER} -p${DB_MIDAS_BACKUP_PASS} -h ${DB_HOST} ${DB_DATABASE_NAME} > ${BACKUP_PATH}/backup$(date +\%Y\%m\%d\%H\%M\%S).dump
