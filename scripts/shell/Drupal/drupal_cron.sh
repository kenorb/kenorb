#!/bin/sh
# Shell script to run Drupal cron job.
# Notes:
# - Suggested location: /etc/cron.hourly
# - Override variables in /etc/default/drupal
# - For Basic Authentication, use AUTH.
HOST="example.com"
CRON_KEY="CHANGE_THIS" # Check: admin/config/system/cron
#AUTH="-u guest:guest"
[ -e /etc/default/drupal ] && . /etc/default/drupal
curl -s $AUTH "http://$HOST/cron.php?cron_key=$CRON_KEY"
