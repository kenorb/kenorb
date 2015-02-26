alias wget-all='wget --user-agent=Mozilla -e robots=off --content-disposition --mirror --convert-links -E -K -N -r -nc -c'
wget-all http://www.zamrize.org/wrapp/ | tee .output.log
