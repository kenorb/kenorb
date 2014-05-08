<?php

/**
 * @file
 *   drush rc configuration file.
 *
 * See `drush topic docs-bootstrap` for more information on how
 * bootstrapping affects the loading of drush configuration files.
 */

/**
 * Useful shell aliases:
 *
 * Drush shell aliases act similar to git aliases.  For best results, define
 * aliases in one of the drushrc file locations between #3 through #6 above.
 * More information on shell aliases can be found via:
 * `drush topic docs-shell-aliases` on the command line.
 *
 * @see https://git.wiki.kernel.org/articles/a/l/i/Aliases.html#Advanced.
 */
$options['shell-aliases'] = array(

  /*
   * Deploy files on local (needs to be run locally)
   * Note: It works only when your current local environment works correctly.
   *
   */
  'deploy-local' => '!
    drush bb db manual &&
    drush sql-sync @uat @self &&
    drush -y rsync @uat:%files @self:%files &&
    drush -y updb &&
    drush cc all &&
    drush -y fra &&
    drush views-dev &&
    drush -y en example_devel &&
    drush cron &&
    drush status-report --severity=2 &&
    echo Deployment completed.
  ',

  /*
   * Deploy files on DEV (needs to be run locally)
   *
   */
  'deploy-dev' => '!
    drush @dev deploy-db &&
    drush @dev fix-git-perms && drush @dev deploy-code && drush @dev fix-git-perms &&
    drush @dev fix-files-perms && drush @dev deploy-files && drush @dev fix-files-perms &&
    drush @dev deploy-drupal
  ',

  /*
   * Deploy files on UAT (needs to be run locally)
   *
   */
  'deploy-uat' => '!
    drush --yes @uat archive-backup &&
    drush @dev deploy-uat &&
    drush @uat fix-git-perms && drush @uat deploy-code && drush @uat fix-git-perms &&
    drush @uat fix-files-perms && drush @uat deploy-files && drush @uat fix-files-perms &&
    drush @uat deploy-drupal
  ',
  // drush @uat deploy-db && // This needs to be added, once we've production env ready.

  /*
   * Deploy files on UAT (needs to be run locally)
   * The following remote needs to be added:
   *   git remote add uat example-uat-new:/var/www
   *
   */
  'deploy-uat-old' => '!
    drush --yes @uat archive-backup &&
    drush @dev deploy-uat &&
    drush @uat deploy-code &&
    drush @uat deploy-files &&
    drush @uat deploy-drupal
  ',
  /*
   * Deploy files on Production (needs to be run locally)
  *
  */
  'deploy-prod' => '!
    drush --yes @prod archive-backup &&
    drush @uat deploy-prod &&
    drush @prod deploy-code &&
    drush @prod deploy-drupal
  ',

  /*
   * example LDAP integration
   *
   */
  'example-ldap-enable' => 'en -y ldap_user',
  'example-ldap-disable' => 'dis -y ldap_user',

  /*
   * example debugs
   *
   */
  'example-debug-enable' => '!
    drush vset --yes rules_debug 2 \
    && drush vset --yes rules_debug_log 1 \
    && drush views-dev
    ',
  'example-debug-disable' => '!
    drush vset --yes rules_debug 0 \
    && drush vset --yes rules_debug_log 0 \
    && drush views-dev
    ',

);

// Control automatically check for updates in pm-updatecode and drush version.
// FALSE = never check for updates.  'head' = allow updates to drush-HEAD.
// TRUE (default) = allow updates to latest stable release.
$options['self-update'] = FALSE;

// Enable verbose mode.
// $options['v'] = TRUE;

/*
 * An array of aliases for common rsync targets.
 */
$options['path-aliases'] = array(
  '%files'   => 'sites/default/files',
  '%private' => 'sites/default/private',
);

// Default logging level for php notices.  Defaults to "notice"; set to "warning"
// if doing drush development.  Also make sure that error_reporting is set to E_ALL
// in your php configuration file.  See 'drush status' for the path to your php.ini file.
$options['php-notices'] = 'warning';

/*
 * Customize this associative array with your own tables. This is the list of
 * tables whose *data* is skipped by the 'sql-dump' and 'sql-sync' commands when
 * a structure-tables-key is provided. You may add new tables to the existing
 * array or add a new element.
 */
$options['structure-tables'] = array(
 'common' => array('cache', 'cache_filter', 'cache_menu', 'cache_page', 'history', 'search_index', 'sessions', 'watchdog'),
);

/**
 * List of tables to be omitted entirely from SQL dumps made by the 'sql-dump'
 * and 'sql-sync' commands when the "--skip-tables-key=common" option is
 * provided on the command line.  This is useful if your database contains
 * non-Drupal tables used by some other application or during a migration for
 * example.  You may add new tables to the existing array or add a new element.
 */
$options['skip-tables'] = array(
 'common' => array('field_deleted_revision_63', 'field_deleted_revision_62', 'field_deleted_revision_60', 'field_deleted_data_60', 'field_deleted_data_63', 'field_deleted_revision_61', 'field_deleted_data_62', 'field_deleted_data_61', 'field_deleted_data_59', 'field_deleted_revision_59'),
);

/**
 * Specify options to pass to ssh in backend invoke.  The default is to prohibit
 * password authentication, and is included here, so you may add additional
 * parameters without losing the default configuration.
 */
# $options['ssh-options'] = '-o PasswordAuthentication=no -F scripts/example/conf/ssh/config';

/*
 * Command-specific options
 *
 * To define options that are only applicable to certain commands,
 * make an entry in the 'command-specific' structures as shown below.
 * The name of the command may be either the command's full name
 * or any of the command's aliases.
 *
 * Options defined here will be overridden by options of the same
 * name on the command line.  Unary flags such as "--verbose" are overridden
 * via special "--no-xxx" options (e.g. "--no-verbose").
 *
 * Limitation: If 'verbose' is set in a command-specific option,
 * it must be cleared by '--no-verbose', not '--no-v', and visa-versa.
 */
$command_specific['rsync'] = array('mode' => 'rlptzO', 'verbose' => TRUE, 'no-perms' => TRUE, 'exclude' => '*.gz');
$command_specific['archive-dump'] = array('verbose' => TRUE);
$command_specific['sql-sync'] = array('verbose' => TRUE, 'sanitize' => TRUE, 'create-db' => TRUE, 'cache' => TRUE, 'structure-tables-key' => 'common', 'skip-tables-key' => 'common');
$command_specific['sql-dump'] = array('ordered-dump' => TRUE, 'structure-tables-key' => 'common', 'skip-tables-key' => 'common');

// Always show release notes when running pm-update or pm-updatecode
$command_specific['pm-update'] = array('notes' => TRUE);
$command_specific['pm-updatecode'] = array('notes' => TRUE);

/**
 * Variable overrides:
 *
 * To override specific entries in the 'variable' table for this site,
 * set them here. Any configuration setting from the 'variable'
 * table can be given a new value. We use the $override global here
 * to make sure that changes from settings.php can not wipe out these
 * settings.
 *
 * Remove the leading hash signs to enable.
 */
$override = array(
  'example_debug_level' => 1,
);

