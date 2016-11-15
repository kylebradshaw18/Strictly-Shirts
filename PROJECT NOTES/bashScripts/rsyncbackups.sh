#!/bin/bash
# Short script to remotely backup 10.10.7.178 tarball files
# crontab is scheduled as 59 23 * * * ~/scripts/rsyncbackups.sh

rsync -ave ssh administrator@10.10.7.178:/home/administrator/backups/files/ /offsitebackups
