#!/bin/sh
# Find all video files and their corresponding XML files and filter through selected criteria.
find -E . -iregex '.*\.(mp4|avi|mkv|divx|wmv|3gp)' -exec sh -c 'cd "`dirname "{}"`" && cat *.xml 2> /dev/null' \; | grep -- "imdbRating=.[6-9]" | grep -- "year=.201" | grep -i -- "language=.English" | grep -o 'title=.[^"]*' | sed 's/.*"//' | grep -vf ~/.imdb/watched.lst -f ~/.imdb/later.lst -f ~/.imdb/horrors.lst
