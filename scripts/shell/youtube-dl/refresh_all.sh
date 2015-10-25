#!/bin/sh
# Execute .refresh.sh in each directory recursively.
find . -name .refresh.sh -execdir sh .refresh.sh ';'

# Longer version:
# find . -name .refresh.sh -exec sh -c 'cd -P -- "$(dirname -- "{}")" && pwd -P && sh .refresh.sh' \;
