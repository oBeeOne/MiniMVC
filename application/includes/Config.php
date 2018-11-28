<?php
/*
*	Config class
*	
*	Holds the config params
*
*/

class Config {
	// vars
    static $confIni = "config.ini";
	static $debug = 1;
	
	// methods
	
        /**
         * Parses the config file
         * @return object returns db config parameters
         */
	static function getDbParams(){
		$parse = parse_ini_file(self::$confIni, true);
		return (object)$parse['database'];
	}
}

/**
 * Adding routes to the router
 */
Route::reform('/', 'index');
Route::reform(':controller', ':controller/index');
Route::reform(':controller/:action/:args',':controller/:action/?(.*)');