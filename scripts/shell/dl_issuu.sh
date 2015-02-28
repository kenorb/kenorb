#!/bin/bash -e
# Script for downloading ISSUE documents into PDF format.
# Usage: ./dl_issuu.sh http://issuu.com/x/docs/x

echo Checking dependencies...
which curl    || { echo Error: Please install curl.;        exit 1; }
which cut     || { echo Error: Please install coreutils.;   exit 1; }
which head    || { echo Error: Please install coreutils;    exit 1; }
which seq     || { echo Error: Please install coreutils;    exit 1; }
which sed     || { echo Error: Please install sed;          exit 1; }
which xargs   || { echo Error: Please install xargs;        exit 1; }
which convert || { echo Error: Please install imagemagick.; exit 1; }
which identify|| { echo Error: Please install imagemagick.; exit 1; }
which file    || { echo Error: Please install file.;        exit 1; }
[ -n "$1" ]   || { echo "Usage: $0 (url)"; exit 1; }

URL="$1"
ARG2="$2"

echo Fetching $URL...
SRC=$(curl -o- $URL || cat -- $URL) # Retrieve URL or local file.
TITLE=$(echo $SRC | grep -o '.og:title. content=.[^"]*' | cut -d \" -f4 | tr -cd "[:alnum:][:punct:][:space:]" )
PAGE1_URL=$(echo $SRC | grep -o 'image.issuu.com/[^"]*' | head -n1)

#[ "$ARG2" = "force" ] || ( mkdir -v "$TITLE" || { echo "File already exists, re-run as: '$0 $URL force' to override."; exit 1; }) # Create new folder.
test -f "$TITLE.pdf" && { echo "File '$TITLE.pdf' already downloaded."; exit 1; }
mkdir -v "$TITLE" || echo "Directory already exists, Resuming download..."
cd "$TITLE"    # Open created or existing folder.

echo Downloading pages for: $TITLE...

FILES=""
for i in `seq 1 2000`; do
  if file page_$i.jpg | grep -i JPEG; then # Check for existing file...
    if identify -verbose -regard-warnings page_$i.jpg >/dev/null; then # Check if file is corrupted ...
      FILES="$FILES page_$i.jpg"; # ... if not, then skip the file as it is already downloaded.
      continue;
    else
      rm -v "page_$i.jpg" # ... if file is corrupted, remove it and re-download it again.
    fi
  fi
  IMG_URL=$(echo $PAGE1_URL | sed "s/page_[[:digit:]]*/page_$i/") # Get next image URL.
  curl --retry 3 -o "page_$i.jpg" $IMG_URL           # Download each page.
  file page_$i.jpg | grep -i JPEG ||                 # Check for file format.
    { rm -v "page_$i.jpg"; break; }                  # If not JPEG file, remove and break the loop.
  FILES="$FILES page_$i.jpg"                         # Add file to the list.
done
echo Converting $i image pages to PDF file...
convert $FILES -gravity center -format pdf ../"$TITLE".pdf || exit 1
echo File: $TITLE.pdf
echo Done.
