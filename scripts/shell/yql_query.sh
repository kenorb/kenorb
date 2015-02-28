#!/bin/sh
# Script to execute YQL query via Yahoo API.
# Usage: ./yql_query.sh query (format) (curl-args)
# Examples:
#  ./yql_query.sh 'SELECT * FROM html WHERE url = "www.example.com"'
#  echo 'SELECT div FROM html WHERE url = "www.example.com"' | ./yql_query.sh - xml -v

[ "$1" != "-" ] && QUERY=$1 || QUERY=$(cat -)           # Read query from 1st argument or stdin (-).
[ "$2" ] && { FORMAT="$2" && shift; }  || FORMAT="json" # Read format from argument (json/xml) or set 'json' as default.
API_URL="http://query.yahooapis.com/v1/public/yql"
shift
curl -G --data-urlencode "q=$QUERY" "$API_URL?format=$FORMAT" $*
