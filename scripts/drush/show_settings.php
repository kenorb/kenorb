#!/bin/sh
drush eval 'include conf_path() . "/settings.php"; print_r($conf);'

