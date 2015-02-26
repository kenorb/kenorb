#!/bin/sh
alias youtube-dl="youtube-dl -R5 -i --write-description  --all-subs --write-info-json --write-thumbnail -o '%(playlist)s/%(title)s-%(id)s.%(ext)s'"
youtube-dl http://www.youtube.com/user/Google | tee .output.log
