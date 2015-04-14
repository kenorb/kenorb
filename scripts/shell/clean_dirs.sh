#/bin/sh
# Script to clean-up recursively the directories from temporary and rubbish files.
# \.sw[op]|\.bak|\.orig\.save
find . \( -name Thumbs.db -or -name .DS_Store -or -name \*.swp -or -name .listing \) -print -delete
