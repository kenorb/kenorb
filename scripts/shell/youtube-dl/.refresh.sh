#!/bin/sh
alias youtube-dl="youtube-dl -R5 -i --all-subs --write-thumbnail --write-description --write-info-json --write-annotations -o '%(playlist)s/%(title)s-%(id)s.%(ext)s'"
youtube-dl http://www.youtube.com/user/Google | tee .output.log
