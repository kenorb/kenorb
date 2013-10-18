#!/bin/sh
# Script for clearing the cache directly via SQL
# Works very fast.
#
# Author: kenorb
#

set -o xtrace
echo "SHOW TABLES LIKE 'cache%'" | `drush sql-connect` | tail +2 | xargs -L1 -I% echo "DELETE FROM %;" | `drush sql-connect` -v
echo 'flush_all' | nc localhost 11211 # Flush Contents Of a Memcached Server
set -o xtrace -
echo done.

