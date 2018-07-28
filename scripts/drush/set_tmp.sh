#!/bin/bash -xe
# Script to determine the temp directory for local httpd environment and set via drush.

WWW_USER="$(ps axo user,group,comm | egrep "(apache|httpd)" | grep -v ^root | uniq | cut -d\  -f 1)"
PHP="$(which php)"

DRUSH="drush"
DIR="$(git rev-parse --show-toplevel 2> /dev/null)"
DOCROOT="public_html"

if [ -n "$PHP" ]; then
  TMP="$(php -r "echo ini_get('upload_tmp_dir');")"
elif [ -n "$WWW_USER" ]; then
  TMP="$(sudo -uwww bash -c 'dirname $(mktemp)')"
elif [ -n "$TMPDIR" ]; then
  TMP="$TMPDIR"
else
  TMP="/tmp"
fi

# Local deployment steps.
drush -r "$DIR/$DOCROOT" -y vset file_temporary_path "$TMP"
