<?php

/**
* @desc Debug & Error Handle
*/
define('LOG_MODE', true);
define('DEBUG_MODE', false);
/**
* @desc Debug & Error Handle
*/
define('DEFAULT_CONTROLLER', 'index');
define('DEFAULT_ACTION', 'index');

/**
 * Define RBAC Basic roles
 */

// RBAC_EVERYONE any one
define('RBAC_EVERYONE',     -1);

// RBAC_HAS_ROLE  have any role
define('RBAC_HAS_ROLE',     -2);

// RBAC_NO_ROLE no role
define('RBAC_NO_ROLE',      -3);

// RBAC_NULL no value
define('RBAC_NULL',         null);

// ACTION_ALL all action in controller
define('ACTION_ALL',        -1);

/**
* @desc Session
*/
define('SESSION_START', true);
define('SESSION_LIFETIME', 1440);
define('SESSION_PATH', '/var/lib/php/session');
define('SESSION_ROLE', 'ROLE_FRONT');
define('SESSION_USER', 'USER_FRONT');
/**
 * @desc now
 */
define('NOW', date("Y-m-d H:i:s"));


define('lodging_cancel_time',3);
?>
