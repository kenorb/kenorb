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

## Update repository
git stash
git svn rebase || git stash pop
git stash pop

## Drupal specific
# Clear caches
sudo -u www-data id && time sudo -u www-data drush -y cc all || time drush -y cc all
# Update database changes
sudo -u www-data id && time sudo -u www-data drush -y updb || time drush -y updb
# Revert all the features
sudo -u www-data id && time sudo -u www-data drush -y fra || time drush -y fra
# Run cron task manually
sudo -u www-data id && time sudo -u www-data drush cron || time drush cron

