find . -name .refresh.sh -exec sh -c 'cd -P -- "$(dirname -- "{}")" && pwd -P && sh .refresh.sh' \;
