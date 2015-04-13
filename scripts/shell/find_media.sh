#!/bin/sh
# Script for finding media files in the current directory recursively.
find -E . -regex '.*\.(mp3|mp4|wav|wma|avi|mkv)'
