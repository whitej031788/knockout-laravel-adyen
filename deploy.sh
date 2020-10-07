#!/bin/bash

if [ $# -ne 2 ]; then
  echo "You must pass 2 arguments, the first the path to the SSH key, the second the EC2 instance domain"
  exit
fi

zip -9 -r --exclude=vendor/* --exclude=.git/* deploy.zip .

sftp -i $1 ubuntu@$2 << HERE
  put deploy.zip
  quit
HERE

ssh -i $1 ubuntu@$2 << EOF
 sudo su
 rm -rfd /var/www/html/adyen
 mkdir /var/www/html/adyen
 mv deploy.zip /var/www/html/adyen
 cd /var/www/html/adyen
 unzip -o deploy.zip
 rm -rf deploy.zip
 composer install
 /usr/bin/php artisan config:cache
 chmod -R 777 /var/www/html/adyen
EOF

retVal=$?

if [ $retVal -ne 0 ]; then
    echo "Error trying to SSH to server, check key and domain"
    exit $retVal
fi
