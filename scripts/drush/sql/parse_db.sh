#!/bin/sh
#
# Script for parsing database and clearing less important data.
# Making the database up to 5x less in size.
#
# Usage:
#   gzcat my_sql.gz | ./parse_db.sh
# You can also pipe it into: `drush sql-connect` with -f to import the db. E.g.:
#   gzcat my_sql.gz | ./parse_db.sh | `drush sql-connect` -f
#
# Author: kenorb
#

CWD="$(cd -P -- "$(dirname -- "$0")" && pwd -P)"
DRUSH="drush"
IGNORE_TABLES="advagg_\w+|cache|cache_\w+|captcha_sessions|comments|comments_\w+|ctools_css_cache|history|locales_\w+|migrate_\w+|mollom|node_comment_statistics|nodewords|profile_values|search_\w+|sessions|subscriptions_\w+|uc_order_log|user_activity|userpoints|userpoints_\w+|watchdog|webform_\w|xmlsitemap+"

grep -vE "INSERT INTO \`($IGNORE_TABLES)\`"

