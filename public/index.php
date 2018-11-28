<?php
/*
 *  Starting application
 *  
 *  initialise session and vars
 * 
 */

// Setting up include path
set_include_path(get_include_path().':'.'../application/config:../application/controllers:../application/includes:../application/lib:../application/models:../application/views');

// setting the base url
defined('BASE_URL') || define('BASE_URL', 'http://phone.digiarts-solutions.net');

// setting the path to application files
defined ('ENV_PATH') || define ('ENV_PATH', realpath(dirname($_SERVER[SCRIPT_FILENAME])));
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__).'/../application'));

// start application
require_once APPLICATION_PATH.'/includes/Loader.php';

// checking for session timout
$sess = new Session();
$sess->timeOut();
        
new Dispatcher();

?>
