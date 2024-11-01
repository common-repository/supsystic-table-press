<?php
    global $wpdb;
    if (!defined('WPLANG') || WPLANG == '') {
        define('TBP_WPLANG', 'en_GB');
    } else {
        define('TBP_WPLANG', WPLANG);
    }
    if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

    define('TBP_PLUG_NAME', basename(dirname(__FILE__)));
    define('TBP_DIR', WP_PLUGIN_DIR. DS. TBP_PLUG_NAME. DS);
    define('TBP_TPL_DIR', TBP_DIR. 'tpl'. DS);
    define('TBP_CLASSES_DIR', TBP_DIR. 'classes'. DS);
    define('TBP_TABLES_DIR', TBP_CLASSES_DIR. 'tables'. DS);
	define('TBP_HELPERS_DIR', TBP_CLASSES_DIR. 'helpers'. DS);
    define('TBP_LANG_DIR', TBP_DIR. 'lang'. DS);
    define('TBP_IMG_DIR', TBP_DIR. 'img'. DS);
    define('TBP_TEMPLATES_DIR', TBP_DIR. 'templates'. DS);
    define('TBP_MODULES_DIR', TBP_DIR. 'modules'. DS);
    define('TBP_FILES_DIR', TBP_DIR. 'files'. DS);
    define('TBP_ADMIN_DIR', ABSPATH. 'wp-admin'. DS);

	define('TBP_PLUGINS_URL', plugins_url());
    define('TBP_SITE_URL', get_bloginfo('wpurl'). '/');
    define('TBP_JS_PATH', TBP_PLUGINS_URL. '/'. TBP_PLUG_NAME. '/js/');
    define('TBP_CSS_PATH', TBP_PLUGINS_URL. '/'. TBP_PLUG_NAME. '/css/');
    define('TBP_IMG_PATH', TBP_PLUGINS_URL. '/'. TBP_PLUG_NAME. '/img/');
    define('TBP_MODULES_PATH', TBP_PLUGINS_URL. '/'. TBP_PLUG_NAME. '/modules/');
    define('TBP_TEMPLATES_PATH', TBP_PLUGINS_URL. '/'. TBP_PLUG_NAME. '/templates/');
    define('TBP_JS_DIR', TBP_DIR. 'js/');

    define('TBP_URL', TBP_SITE_URL);

    define('TBP_LOADER_IMG', TBP_IMG_PATH. 'loading.gif');
	define('TBP_TIME_FORMAT', 'H:i:s');
    define('TBP_DATE_DL', '/');
    define('TBP_DATE_FORMAT', 'm/d/Y');
    define('TBP_DATE_FORMAT_HIS', 'm/d/Y ('. TBP_TIME_FORMAT. ')');
    define('TBP_DATE_FORMAT_JS', 'mm/dd/yy');
    define('TBP_DATE_FORMAT_CONVERT', '%m/%d/%Y');
    define('TBP_WPDB_PREF', $wpdb->prefix);
    define('TBP_DB_PREF', 'tbp_');
    define('TBP_MAIN_FILE', 'tbp.php');

    define('TBP_DEFAULT', 'default');
    define('TBP_CURRENT', 'current');
	
	define('TBP_EOL', "\n");    
    
    define('TBP_PLUGIN_INSTALLED', true);
    define('TBP_VERSION', '1.0.1');
    define('TBP_USER', 'user');
    
    define('TBP_CLASS_PREFIX', 'tbpc');     
    define('TBP_FREE_VERSION', false);
	define('TBP_TEST_MODE', true);
    
    define('TBP_SUCCESS', 'Success');
    define('TBP_FAILED', 'Failed');
	define('TBP_ERRORS', 'tbpErrors');
	
	define('TBP_ADMIN',	'admin');
	define('TBP_LOGGED','logged');
	define('TBP_GUEST',	'guest');
	
	define('TBP_ALL', 'all');
	
	define('TBP_METHODS', 'methods');
	define('TBP_USERLEVELS', 'userlevels');
	/**
	 * Framework instance code
	 */
	define('TBP_CODE', 'tbp');
	define('TBP_LANG_CODE', 'tbp_lng');
	/**
	 * Plugin name
	 */
	define('TBP_WP_PLUGIN_NAME', 'Table Press by Supsystic');
	/**
	 * Custom defined for plugin
	 */
	define('TBP_SHORTCODE', 'tbp-table-press');


