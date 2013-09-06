#!/bin/bash
# Scripts which dumps general info and dependencies provided by the module
# Usage: ./$0 module_name
#
# Example usage:
#   find . -name \*.module | xargs -L1 basename | sed s/.module//g | xargs -I% -L1 sh -c 'echo File: `dirname $(find . -name %.module)`/README_UPGRADE_%_6.txt; ../../../dev-scripts/show_module_deps.sh % | tee `dirname $(find . -name %.module)`/README_UPGRADE_%_6.txt'

MODULE="$1"

# set -o xtrace
echo -e "## $1 module ##"
echo -e "General information about $MODULE module:"
drush pm-info $MODULE

echo -e "\n\nUpdate release notes for $MODULE module:"
( ( yes "n" | drush --notes pm-updatecode $MODULE ) | grep -ve "Up to date" -e "Update available" -e "SECURITY UPDATE available" -e "not supported" -e "^Note:" -e "Do you really want" ) || echo No release notes for $MODULE module.

echo -e "\n\nVariables used by $MODULE module:"
(drush vget ^$MODULE) || echo No variables found for $MODULE module.

echo -e "\n\nDatabase records used by module:"
(drush --ordered-dump sql-dump | grep $MODULE | grep -v "``cache" | awk 'length($0) < 200') || echo Nothing found in db for $MODULE module.

echo -e "\n\nDefined drush commands for $MODULE module:"
(drush help | grep $MODULE) || echo No drush command found for $MODULE module.

echo -e "\n\nDrupal watchdog messages for $MODULE module:"
drush watchdog-show $MODULE || echo No log messages available.

echo -e "\n\nCoding standards for $MODULE module:"
drush coder $MODULE

echo -e "\n\nTables used by module:"
drush eval "print_r(array_keys(drupal_get_schema_unprocessed('$MODULE')));"
