#!/bin/sh
# Script to remove trailing whitespace of all files recursively
# See: http://stackoverflow.com/questions/149057/how-to-remove-trailing-whitespace-of-all-files-recursively

case "$OSTYPE" in
  darwin*) # OSX 10.5 Leopard, which does not use GNU sed or xargs.
    find . -type f -not -iwholename '*.git*' -print0  | xargs -0 sed -i .bak -E "s/[[:space:]]*$//"
    find . -type f -name \*.bak -print0 | xargs -0 rm -v
    ;;
  *)
    find . -type f -not -iwholename '*.git*' -print0 | xargs -0 perl -pi -e 's/ +$//'
esac
