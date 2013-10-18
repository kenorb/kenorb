#!/bin/sh
# Upgrade all modules which are not installed
#

drush -y en update
drush pm-list | grep "Not installed" | grep -o "([_0-9a-z]*)" | grep -o "[^(].*[^)]" | xargs -L1 drush -yv upc
# drush pm-list | grep "Not installed" | grep -o "([_0-9a-z]*)" | grep -o "[^(].*[^)]" | xargs -L1 drush -yv dl

