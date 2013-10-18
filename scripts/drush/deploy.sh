#!/bin/bash
# Script which updating the current repository with the latest changes
# It will require svn credentials.
# Suggested file placement under Drupal root: scripts
#
# Usage: ./$0
#

CWD="$(cd -P -- "$(dirname -- "$0")" && pwd -P)"

if [ ! -w "$0" ]; then
  echo "Permission denied."
  echo "Please re-run this script with root rights (followed by sudo)."
  exit 1
fi

set -o xtrace

# Enable maintanance mode
drush -y vset maintenance_mode 1

## Update repository
git stash
git svn rebase || git stash pop
git stash pop

## Drupal specific
# Clear caches
sudo -u www-data id && time sudo -u www-data drush -y cc all || time drush -y cc all

# Sometimes this helps, read more: https://drupal.org/node/1454468
# echo "DELETE FROM cache_bootstrap;" | drush sqlc

# Update database changes
sudo -u www-data id && time sudo -u www-data drush -y updb || time drush -y updb

# Disable maintanance mode
drush -y vset maintenance_mode 0

# Revert all the features
sudo -u www-data id && time sudo -u www-data drush -y fra || time drush -y fra
# Run cron task manually
sudo -u www-data id && time sudo -u www-data drush cron || time drush cron

# Show recent log entries
drush watchdog-show

# Show site warnings and errors
drush status-report | grep -e Warning -e Error

