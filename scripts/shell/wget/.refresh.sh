alias wget-all='wget --user-agent=Mozilla -e robots=off --content-disposition -m --convert-links -E -K -nc -c'
wget-all http://www.zamrize.org/wrapp/ | tee .output.log
