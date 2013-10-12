<?php

/**
 * Setup the timezone
 */
date_default_timezone_set('Europe/Amsterdam');

/**
 * Setup the database connection
 */
$dbConnection = new \PDO('mysql:dbname=pushy;host=127.0.0.1;charset=utf8', 'user', 'pass');
$dbConnection->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
$dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
