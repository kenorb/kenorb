<?php
/*
 * Helpful script to modify Drupal REQUEST_TIME.
 *
 * Example usages:
 *   - creating users on specific dates,
 *   - creating commerce/ubercart orders with yesterdays date etc.
 * Usage examples:
 *   REQUEST_TIME=1400082044 drush --early=drush_change_date.php.inc eval "print REQUEST_TIME"
 *   NEW_REQUEST_TIME=`case "$OSTYPE" in darwin*) date -v-1d "+%s"; ;; *) date -d "1 days ago" "+%s"; esac` drush --early=drush_change_date.php.inc eval "print REQUEST_TIME"
 *   NEW_REQUEST_TIME=`case "$OSTYPE" in darwin*) date -v-1d "+%s"; ;; *) date -d "1 days ago" "+%s"; esac` drush --early=drush_change_date.php.inc coa SKU1001
 *
 * See also:
 *   - https://github.com/drush-ops/drush/issues/633
 *   - http://stackoverflow.com/questions/3517982/in-a-unix-shell-how-to-get-yesterdays-date-into-a-variable/23682903
 */
$_SERVER['REQUEST_TIME'] = (int)$_SERVER['NEW_REQUEST_TIME'] ?: (int)$_SERVER['REQUEST_TIME'];

