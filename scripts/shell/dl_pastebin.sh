#!/bin/sh
# Script to download trending files at pastebin.com.
OUT="pastebin"
HOST="http://pastebin.com"
wget -NP "$OUT" -w1 $HOST/trends $HOST/trends/week $HOST/trends/month $HOST/trends/year $HOST/trends/all
cd "$OUT"
for file in trends week month year all; do
  URLS=$(ex +'/<table/norm yit' +'%d|pu0' +'v/href/d' +'%s/.*href=.\/\(.\{-}\)["].*/\1/' +%sort +'%!uniq' +%p -scq! $file)
  for uri in $URLS; do
    wget -c -nc --content-disposition -w1 --header="Referer:$HOST/$uri" -U Mozilla "${HOST}/download.php?i=${uri}"
  done
done
