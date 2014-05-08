#!/bin/bash
# Show database differences between two remote environments.
#
# Usage:
#   db_diff_show.sh (@env1) (@env2)
# Where
#   @env1,@env2 - defined drush site alias (see: drush help site-alias)
#
# Examples:
#   ./db_diff_show.sh @dev @uat
#   ./db_diff_show.sh @uat @prod -iw
#   ./db_diff_show.sh @uat @prod | vim -R -
#   DIFF="vimdiff" ./db_diff_show.sh @uat @prod
#   DIFF="colordiff" ./db_diff_show.sh @uat @prod -u
#   DIFF="kdiff3" ./db_diff_show.sh @uat @prod
#   DIFF="tkdiff" ./db_diff_show.sh @uat @prod
#

TABLES="node,node_revision,block,field_config"

if [ ! -n "$2" ]; then
  echo "Usage:"
  echo "  $0 (@env1) (@env2)"
  exit 1
fi

if [ ! -n "$DIFF" ]; then
  DIFF="diff -u"
fi

$DIFF <(drush $2 sql-dump --tables-list=$TABLES) <(drush $1 sql-dump --tables-list=$TABLES) ${@:3}
