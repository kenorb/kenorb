#!/bin/sh
# Script to download 1st page of user most popular videos.
alias youtube-dl="youtube-dl -R5 -i --write-description  --all-subs --write-info-json --write-thumbnail -o '%(playlist)s/%(title)s-%(id)s.%(ext)s'"
YUSER="google"
URL="https://www.youtube.com/user/$YUSER/videos?sort=p"
videos=$(curl -A Mozilla -s "$URL" | grep -o '/watch?v=[^"]*' | while read line; do echo "http://www.youtube.com$line"; done | uniq)
youtube-dl $videos | tee .output.log && touch .done
