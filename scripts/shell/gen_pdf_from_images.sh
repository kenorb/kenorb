#!/bin/sh
# Script scanning directories for consecutive PNG/JPEG files and generating PDF files.
find . -type d -exec sh -c 'cd "{}"; ls *010.png 2> /dev/null && convert *.png -adjoin "`basename \"{}\"`.pdf" && ls *.pdf ' \;
find . -type d -exec sh -c 'cd "{}"; ls *010.jpg 2> /dev/null && convert *.jpg -adjoin "`basename \"{}\"`.pdf" && ls *.pdf ' \;
