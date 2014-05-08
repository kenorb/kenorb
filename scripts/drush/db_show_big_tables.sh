#!/bin/sh
# Display the biggest MySQL tables via drush.
#
# See: http://stackoverflow.com/questions/9620198/how-to-get-the-sizes-of-the-tables-of-a-mysql-database

DB_NAME=$(drush status --fields=db-name --field-labels=0 | tr -d '\r\n ')
drush sqlq "SELECT table_name AS 'Tables', round(((data_length + index_length) / 1024 / 1024), 2) 'Size in MB' FROM information_schema.TABLES WHERE table_schema = \"${DB_NAME}\" ORDER BY (data_length + index_length) DESC;" | head -n20

# drush sql-dump | grep ^INSERT | awk '{print length, $0}' | grep -oE '^.*`\S+`' | sort -n # Not working properly
