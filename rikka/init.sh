#!/bin/bash

mount -t cifs ${NAS_PATH} /mnt/nas -o username=${NAS_USER},password=${NAS_PASS},iocharset=utf8,rw,uid=0,gid=0

/usr/sbin/crond
crontab /home/root/crontab_setting

