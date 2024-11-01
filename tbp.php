<?php
/**
 * Plugin Name: Table Press by Supsystic
 * Plugin URI:
 * Description: Post your data easy in tables
 * Version: 1.0.1
 * Author: supsystic.com
 * Author URI: https://supsystic.com
 **/
	/**
	 * Base config constants and functions
	 */
    require_once(dirname(__FILE__). DIRECTORY_SEPARATOR. 'config.php');
    require_once(dirname(__FILE__). DIRECTORY_SEPARATOR. 'functions.php');
	/**
	 * Connect all required core classes
	 */
    importClassTbp('dbTbp');
    importClassTbp('installerTbp');
    importClassTbp('baseObjectTbp');
    importClassTbp('moduleTbp');
    importClassTbp('modelTbp');
    importClassTbp('viewTbp');
    importClassTbp('controllerTbp');
    importClassTbp('helperTbp');
    importClassTbp('dispatcherTbp');
    importClassTbp('fieldTbp');
    importClassTbp('tableTbp');
    importClassTbp('frameTbp');
	/**
	 * @deprecated since version 1.0.1
	 */
    importClassTbp('langTbp');
    importClassTbp('reqTbp');
    importClassTbp('uriTbp');
    importClassTbp('htmlTbp');
    importClassTbp('responseTbp');
    importClassTbp('fieldAdapterTbp');
    importClassTbp('validatorTbp');
    importClassTbp('errorsTbp');
    importClassTbp('utilsTbp');
    importClassTbp('modInstallerTbp');
	importClassTbp('installerDbUpdaterTbp');
	importClassTbp('dateTbp');
	/**
	 * Check plugin version - maybe we need to update database, and check global errors in request
	 */
    installerTbp::update();
    errorsTbp::init();
    /**
	 * Start application
	 */
    frameTbp::_()->parseRoute();
    frameTbp::_()->init();
    frameTbp::_()->exec();
	
	//var_dump(frameTbp::_()->getActivationErrors()); exit();
