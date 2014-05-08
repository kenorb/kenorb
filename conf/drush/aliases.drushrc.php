<?php

/**
 * @file
 *   Alias file for drush command line tool.
 *
 * See:
 *  http://drush.ws/docs/shellaliases.html
 *
 *  Example usage:
 *    drush @dev status
 *    drush @uat status
 *    drush @dev deploy-code
 *
 */

/**
 * Alias for Development environment run on Drupal 7.
 *
 */
$aliases['global'] = array(
    // 'ssh-options' => "-p 1022 -F %root/scripts/example/conf/ssh/config" . DRUPAL_ROOT,
    'path-aliases' => array(
      '%files'   => 'sites/default/files',
      '%private' => 'sites/default/private',
    ),

    'source-command-specific' => array (
      'sql-sync' => array (
        'structure-tables-key' => 'common',
        'skip-tables-key' => 'common'
      ),
    ),
    // target-command-specific
    'command-specific' => array (
      'sql-sync' => array (
        'cache' => TRUE,
        'create-db' => TRUE,
        'sanitize' => TRUE,
        'ordered-dump' => FALSE,
        'structure-tables-key' => 'common',
        'skip-tables-key' => 'common',
        'structure-tables' => array(
          // You can add more tables which contain data to be ignored by the database dump
          'common' => array('cache', 'cache_filter', 'cache_menu', 'cache_page', 'history', 'search_index', 'sessions', 'watchdog'),
        ),
        'skip-tables' => array(
          'common' => array('field_deleted_revision_63', 'field_deleted_revision_62', 'field_deleted_revision_60', 'field_deleted_data_60', 'field_deleted_data_63', 'field_deleted_revision_61', 'field_deleted_data_62', 'field_deleted_data_61', 'field_deleted_data_59', 'field_deleted_revision_59'),
        ),
      ),
      'sql-dump' => array (
        'ordered-dump' => TRUE,
        'structure-tables-key' => 'common',
        'skip-tables-key' => 'common',
        'structure-tables' => array(
          // You can add more tables which contain data to be ignored by the database dump
          'common' => array('cache', 'cache_filter', 'cache_menu', 'cache_page', 'history', 'search_index', 'sessions', 'watchdog'),
        ),
        'skip-tables' => array(
          'common' => array('field_deleted_revision_63', 'field_deleted_revision_62', 'field_deleted_revision_60', 'field_deleted_data_60', 'field_deleted_data_63', 'field_deleted_revision_61', 'field_deleted_data_62', 'field_deleted_data_61', 'field_deleted_data_59', 'field_deleted_revision_59'),
        ),
      ),
      'rsync' => array('mode' => 'rlptzO', 'verbose' => TRUE, 'no-perms' => TRUE, 'exclude' => '*.gz'),
    ), // end: command-specific
);

/**
 * Alias for Development environment run on Drupal 7.
 *
 */
$aliases['dev'] = array(
    'uri' => 'www-dev-drupal7.example.com',
    'root' => '/var/www/drupal7',
    'parent' => '@global',
    'remote-host' => 'example-dev',

    /*
    'options' => array(
      'ssh-options' => 'BLAH -o PasswordAuthentication=no -F scripts/example/conf/ssh/config',
    ),
    */

    'variables' => array('mail_system' => array('default-system' => 'DevelMailLog')),

    # This shell alias will run `mycommand` when executed via `drush @stage site-specific-alias`
    'shell-aliases' => array(

      /*
       * Deploy code on DEV from git dev branch
       *
       */
      'deploy-code' => '!git fetch origin && sudo git stash && sudo git reset origin/dev --hard',

      /*
       * Deploy database on DEV from UAT
       *
       */
      'deploy-db' => '!
        sudo -uwww-data drush --watchdog=print bb db manual &&
        drush sql-sync --yes @uat @self
      ',

      /*
       * Deploy files on DEV from UAT
       *
       *  Notes:
       *    origin git-drupal@git:~git/exampledotcom
       *   'deploy-files' => '!git fetch origin master && sudo git stash && sudo git reset origin/master --hard && sh ./scripts/example/deploy.sh',
       *    E.g. drush sql-sync @prod default --no-cache --dump-dir=/tmp --structure-tables-key=common --sanitize
       *    See: http://shomeya.com/articles/using-per-project-drush-commands-to-simplify-your-development
       *
       *  Requirements:
       *    sudo chown -R www-data:root /var/www/drupal7/sites/default/files /var/www/drupal7/sites/default/private
       *    sudo chmod ug+w /var/www/drupal7/sites/default/files /var/www/drupal7/sites/default/private
       */
      'deploy-files' => '!drush --yes rsync @uat:%files @self:%files',
        // sudo -uwww-data drush @uat status
        // echo sudo chown -R %apache:root %files %private

      /*
       * Drupal deployment on UAT
       *
       * Permission requirements:
       *   sudo chown -R root:root /var/www/drupal7
       *   sudo chown -R www-data:root /var/www/drupal7/sites/default/private /var/www/drupal7/sites/default/files
       */
      'deploy-drupal' => "!
        sudo -uwww-data drush status &&
        sudo -uwww-data drush --watchdog=print bb db manual &&
        sudo -uwww-data drush --watchdog=print -y updb &&
        sudo -uwww-data drush --watchdog=print cc all &&
        sudo -uwww-data drush --watchdog=print -y fra &&
        sudo -uwww-data drush --watchdog=print cron &&
        sudo -uwww-data drush status-report --severity=2 &&
        echo Deployment completed.
      ",

      /*
       * Deploy code from DEV into UAT
       *
       * Troubleshooting:
       *  - In case of error like 'remote: error: refusing to update checked out branch: refs/heads/master'
       *    on UAT you've to run: git config receive.denyCurrentBranch ignore
       */
      'deploy-uat' => '!git push uat dev master --force',

      /*
       * Fix git permissions to support multiple user git deployment.
       *
       */
      'fix-git-perms' => "!
        sudo chown -R root:root .git &&
        sudo chmod -R ug+w .git &&
        git config core.sharedRepository group
      ",

      /*
       * Fix files permissions to support multiple user rsync deployment.
       *
       */
      'fix-files-perms' => "!
        sudo chown -R www-data:root sites/default/private sites/default/files &&
        sudo chmod -R ug+w sites/default/private sites/default/files
      ",

      /*
       * General deployment to DEV
       * FIXME: Ideally it should be: 'deploy' => 'deploy-db && deploy-code && deploy-files && deploy-drupal'
       *
       */
      'deploy' => 'deploy-code',
    ),
);

/**
 * Alias for UAT environment run on Drupal 7.
 *
 */
$aliases['uat'] = array(
    'uri' => 'www-uat-drupal7.example.com',
    'root' => '/var/www',
    'parent' => '@global',
    'remote-host' => 'example-uat',

    'command-specific' => array (
      'sql-sync' => array (
        'no-cache' => FALSE,
        'sanitize' => TRUE,
        'no-ordered-dump' => TRUE,
        'structure-tables' => array(
        // You can add more tables which contain data to be ignored by the database dump
          'common' => array('cache', 'cache_filter', 'cache_menu', 'cache_page', 'history', 'sessions', 'watchdog'),
        ),
      ),
      'rsync' => array('mode' => 'rlptzO', 'verbose' => TRUE, 'no-perms' => TRUE, 'exclude' => '*.gz'),
    ),

    # This shell alias will run `mycommand` when executed via `drush @stage site-specific-alias`
    'shell-aliases' => array(

      /*
       * Deploy code on UAT from existing git dev
       *
       */
      'deploy-code' => '!./scripts/example/git/git-deploy-tag.sh UAT && sudo git stash && sudo git reset HEAD --hard',
      
      'deploy-files' => '--yes rsync @prod:sites/default/files @self:sites/default/files',

      /*
       * Drupal deployment on UAT
       *
       * Permission requirements:
       *   sudo chown -R root:root /var/www
       *   sudo chown -R www-data:root /var/www/sites/default/private /var/www/sites/default/files
       */
      'deploy-drupal' => "!
        sudo -u www-data www-data drush status &&
        sudo -u www-data www-data drush --watchdog=print bb db manual &&
        sudo -u www-data www-data drush --watchdog=print -y updb &&
        sudo -u www-data www-data drush --watchdog=print cc all &&
        sudo -u www-data www-data drush --watchdog=print -y fra &&
        sudo -u www-data www-data drush --watchdog=print cron &&
        sudo -u www-data www-data drush status-report --severity=2 &&
        echo Deployment completed.
      ",

      /*
       * Deploy code from UAT into PROD
       *
       * Troubleshooting:
       *  - In case of error like 'remote: error: refusing to update checked out branch: refs/heads/master'
       *    on PROD you've to run: git config receive.denyCurrentBranch ignore
       */
      'deploy-prod' => '!git push prod master --force',

      /*
       * Fix git permissions to support multiple user git deployment.
       *
       */
      'fix-git-perms' => "!
        sudo chown -R root:root .git &&
        sudo chmod -R ug+w .git &&
        git config core.sharedRepository group
      ",

      /*
       * Fix files permissions to support multiple user rsync deployment.
       *
       */
      'fix-files-perms' => "!
        sudo chown -R www-data:root sites/default/private sites/default/files &&
        sudo chmod -R ug+w sites/default/private sites/default/files
      ",

      /*
       * General deployment to DEV
       * FIXME: Ideally it should be: 'deploy' => 'deploy-db && deploy-code && deploy-files && deploy-drupal'
       *
       */
      'deploy' => 'deploy-code',
    ),
);

/**
 * Alias for Production environment run on Drupal 7.
 *
 */
$aliases['prod'] = array(
    'uri' => 'www-prod.example.com',
    'root' => '/var/www',
    'remote-host' => 'example-prod',
    'path-aliases' => array(
      '%files'   => 'sites/default/files',
      '%private' => 'sites/default/private',
     ),

    'command-specific' => array (
      'sql-sync' => array (
        'no-cache' => FALSE,
        'sanitize' => TRUE,
        'structure-tables' => array(
        // You can add more tables which contain data to be ignored by the database dump
          'common' => array('cache', 'cache_filter', 'cache_menu', 'cache_page', 'history', 'sessions', 'watchdog'),
        ),
      ),
      'sql-dump' => array (
        'ordered-dump' => TRUE,
      ),
    ),

    # This shell alias will run `mycommand` when executed via `drush @stage site-specific-alias`
    'shell-aliases' => array(

      /*
       * Deploy code on PROD from existing git master
       *
       */
      'deploy-code' => '!sudo git stash && sudo git reset HEAD --hard',

      /*
       * Drupal deployment on PROD
       *
       * Permission requirements:
       *   sudo chown -R root:root /var/www
       *   sudo chown -R www-data:root /var/www/sites/default/private /var/www/sites/default/files
       */
      'deploy-drupal' => "!
        sudo -u www-data www-data drush status &&
        sudo -u www-data www-data drush --watchdog=print bb db manual &&
        sudo -u www-data www-data drush --watchdog=print -y updb &&
        sudo -u www-data www-data drush --watchdog=print cc all &&
        sudo -u www-data www-data drush --watchdog=print -y fra &&
        sudo -u www-data www-data drush --watchdog=print cron &&
        sudo -u www-data www-data drush status-report --severity=2 &&
        echo Deployment completed.
      ",

      /*
       * Fix git permissions to support multiple user git deployment.
       *
       */
      'fix-git-perms' => "!
        sudo chown -R root:root .git &&
        sudo chmod -R ug+w .git &&
        git config core.sharedRepository group
      ",

      /*
       * General deployment to PROD
       * FIXME: Ideally it should be: 'deploy' => 'deploy-db && deploy-code && deploy-files && deploy-drupal'
       *
       */
      'deploy' => 'deploy-code',
    ),
);


/**
 * Alias for Development environment for Drupal 6.
 *
 */
$aliases['dev6'] = array(
    'uri' => 'www.example.com',
    'root' => '/var/www/drupal',
    'remote-host' => 'example-dev',
    'path-aliases' => array(
      '%files'   => 'sites/default/files',
      '%private' => 'sites/default/files/private',
     ),

    'command-specific' => array (
      'sql-sync' => array (
        'no-cache' => FALSE,
        'sanitize' => TRUE,
        'no-ordered-dump' => TRUE,
        'structure-tables' => array(
        // You can add more tables which contain data to be ignored by the database dump
          'common' => array('cache', 'cache_filter', 'cache_menu', 'cache_page', 'history', 'sessions', 'watchdog'),
        ),
      ),
      'rsync' => array('mode' => 'rlptzO', 'verbose' => TRUE, 'no-perms' => TRUE, 'exclude' => '*.gz'),
    ),
);

/**
 * Alias for UAT environment for Drupal 6.
 *
 */
$aliases['uat6'] = array(
    'uri' => 'www-uat.example.com',
    'root' => '/var/www/drupal-new',
    'remote-host' => 'example-uat-old',
    'path-aliases' => array(
      '%files'   => 'sites/default/files',
      '%private' => 'sites/default/files/private',
     ),

    'command-specific' => array (
      'sql-sync' => array (
        'no-cache' => FALSE,
        'sanitize' => TRUE,
        'no-ordered-dump' => TRUE,
        'structure-tables' => array(
        // You can add more tables which contain data to be ignored by the database dump
          'common' => array('cache', 'cache_filter', 'cache_menu', 'cache_page', 'history', 'sessions', 'watchdog'),
        ),
      ),
      'rsync' => array('mode' => 'rlptzO', 'verbose' => TRUE, 'no-perms' => TRUE, 'exclude' => '*.gz'),
    ),
);


/**
 * Alias for old Production environment run for Drupal 6.
 *
 */
$aliases['prod6'] = array(
    'uri' => 'www.example.com',
    'root' => '/var/www/drupal',
    'remote-host' => 'example-prod-old',
    'path-aliases' => array(
      '%files'   => 'sites/default/files',
      '%private' => 'sites/default/files/private',
     ),

    'command-specific' => array (
      'sql-sync' => array (
        'no-cache' => FALSE,
        'sanitize' => TRUE,
        'no-ordered-dump' => TRUE,
        'structure-tables' => array(
        // You can add more tables which contain data to be ignored by the database dump
          'common' => array('cache', 'cache_filter', 'cache_menu', 'cache_page', 'history', 'sessions', 'watchdog'),
        ),
      ),
    ),

);

