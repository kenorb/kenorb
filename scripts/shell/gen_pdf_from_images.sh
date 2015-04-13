#!/bin/bash
# Script scanning directories for consecutive PNG/JPEG files and generating PDF files.
find . -type d -exec sh -c 'cd "{}"; ls *010.png 2> /dev/null && convert `ls *.{png,jpg}` -adjoin "`basename \"{}\"`.pdf" && ls *.pdf && echo rm -v *.png *.jpg ' \;
