#!/bin/sh

sh $1

if [ $? -eq 0 ]; then
  # success
  sh /home/root/alert.sh 0
else
  # failed
  sh /home/root/alert.sh 1
fi


