#!/bin/sh
# Script for finding magnet links from html files and opens them.
grep -Ho 'magnet:[^"]*' *.html > magnets.txt
cat magnets.txt | xargs -L1 -J% open "%"
