#!/bin/bash
# Script to execute YQL query via Yahoo API from the command line.
# Usage: ./yql_query.sh query (format) (curl-args)
# Examples:
#  ./yql_query.sh 'SELECT * FROM html WHERE url = "www.example.com"'
#  echo 'SELECT div FROM html WHERE url = "www.example.com"' | ./yql_query.sh - xml -v

[ "$1" != "-" ] && query="$1" || query=$(cat -)   # Read query from 1st argument or stdin (-).
format=${2:-xml}                                  # Read format (default to xml).
# test -f "$HOME/.yqlrc" && source <(grep = $HOME/.yqlrc)  # Load extra values from ~/.yqlrc if exist.
url_api="http://query.yahooapis.com/v1/public/yql"
curl -G --data-urlencode "q=$query" "$url_api?format=$format" ${@:3}
