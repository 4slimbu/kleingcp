<?php

use Dotenv\Dotenv;

// Start the session
session_start();


// Load Constants
require_once dirname(dirname(__FILE__)) . '/src/constants.php';

// Autoload 
require_once ROOT_DIR . '/vendor/autoload.php';

// Load Env
$dotenv = Dotenv::createImmutable(ROOT_DIR);
$dotenv->load();

// load helper file
require_once ROOT_DIR . '/src/helper.php';

// Load config
require_once ROOT_DIR . '/src/config.php';

// connect database
require_once ROOT_DIR . '/src/db.php';

// Routing
require_once ROOT_DIR . '/src/routes.php';
