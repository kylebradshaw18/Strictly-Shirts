#!/bin/sh
# This script takes the Strictly Shirts MySQL database and Apache code and compiles them into tarballs.
# Scheduled in crontab as 1 1 * * * ~/backups/backup.sh

THESITE="StrictlyShirts"
THEDB="strictly_shirts"
THEDBUSER="root"
THEDBPW=""
THEDATE=`date +%d%m%y%H%M`

mysqldump -u $THEDBUSER -p${THEDBPW} $THEDB | gzip > /home/administrator/backups/files/dbbackup_${THEDB}_${THEDATE}.bak.gz

tar czf /home/administrator/backups/files/sitebackup_${THESITE}_${THEDATE}.tar -C / /var/www/html
gzip /home/administrator/backups/files/sitebackup_${THESITE}_${THEDATE}.tar

find /home/administrator/backups/files/site* -mtime +5 -exec rm {} \;
find /home/administrator/backups/files/site* -mtime +5 -exec rm {} \;
