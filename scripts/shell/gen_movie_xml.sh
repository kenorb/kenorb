#!/bin/sh
# Using imdbtool.py, find all movie files recursively and add relevant XML data from IMDb database.
which imdbtool2.py || ( echo "IMDb tool missing, please install!"; exit 1 )
find -E . -iregex '.*\.(mp4|avi|mkv|divx|wmv|3gp)' -exec sh -c 'set -x; cd "`dirname "{}"`" && ls *.xml 2> /dev/null || (imdbtool.py -t "`basename "$PWD"`" -r XML | tee "`basename "{}"`.xml")' \;
find . -name \*.xml -exec sh -c 'grep "Movie not found" "{}" && rm "{}"' \;
