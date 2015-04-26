#!/bin/sh
# Script for finding video files in the current directory recursively.
find -E . -iregex '.*\.(mp4|avi|mkv|divx|wmv|3gp)'
