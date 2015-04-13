#!/bin/bash
# Script scanning directories for consecutive PNG/JPEG files and generating PDF files.
#find . -type d -exec sh -c 'cd "{}"; ls *010*.png 2> /dev/null && convert `ls *.{png,jpg,gif}` -adjoin "`basename \"{}\"`.pdf" && ls *.pdf && echo rm -v *.png *.jpg ' \;
find . \( -name \*010\*.jpg -o -name \*010\*.png \) -exec sh -c 'cd "`dirname "{}"`" && pwd && convert `ls *.{png,jpg,gif} 2> /dev/null` -adjoin "$(basename "`pwd`").pdf" && ls *.pdf && rm -v *.png *.jpg' \;
