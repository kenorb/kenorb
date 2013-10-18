#!/bin/sh
set -o xtrace
URL="`drush sqlq "SELECT location FROM watchdog ORDER BY wid LIMIT 1" | tail -n1`"
open `drush -l $URL uli`
