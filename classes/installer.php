<?php
class installerTbp {
	static public $update_to_version_method = '';
	static private $_firstTimeActivated = false;
	static public function init( $isUpdate = false ) {
		global $wpdb;
		$wpPrefix = $wpdb->prefix; /* add to 0.0.3 Versiom */
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		$current_version = get_option($wpPrefix. TBP_DB_PREF. 'db_version', 0);
		if(!$current_version)
			self::$_firstTimeActivated = true;
		/**
		 * modules 
		 */
		if (!dbTbp::exist("@__modules")) {
			dbDelta(dbTbp::prepareQuery("CREATE TABLE IF NOT EXISTS `@__modules` (
			  `id` smallint(3) NOT NULL AUTO_INCREMENT,
			  `code` varchar(32) NOT NULL,
			  `active` tinyint(1) NOT NULL DEFAULT '0',
			  `type_id` tinyint(1) NOT NULL DEFAULT '0',
			  `label` varchar(64) DEFAULT NULL,
			  `ex_plug_dir` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE INDEX `code` (`code`)
			) DEFAULT CHARSET=utf8;"));
			dbTbp::query("INSERT INTO `@__modules` (id, code, active, type_id, label) VALUES
				(NULL, 'adminmenu',1,1,'Admin Menu'),
				(NULL, 'options',1,1,'Options'),
				(NULL, 'user',1,1,'Users'),
				(NULL, 'pages',1,1,'Pages'),
				(NULL, 'templates',1,1,'templates'),
				(NULL, 'supsystic_promo',1,1,'supsystic_promo'),
				(NULL, 'admin_nav',1,1,'admin_nav'),
				
				(NULL, 'tablepress',1,1,'tablepress'),
				(NULL, 'mail',1,1,'mail');");
		}
		/**
		 *  modules_type 
		 */
		if(!dbTbp::exist("@__modules_type")) {
			dbDelta(dbTbp::prepareQuery("CREATE TABLE IF NOT EXISTS `@__modules_type` (
			  `id` smallint(3) NOT NULL AUTO_INCREMENT,
			  `label` varchar(32) NOT NULL,
			  PRIMARY KEY (`id`)
			) AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;"));
			dbTbp::query("INSERT INTO `@__modules_type` VALUES
				(1,'system'),
				(6,'addons');");
		}
		/**
		 * tables table
		 */
		if (!dbTbp::exist("@__tables")) {
			dbDelta(dbTbp::prepareQuery("CREATE TABLE IF NOT EXISTS `@__tables` (
				`id` INT(11) NOT NULL AUTO_INCREMENT,
				`title` VARCHAR(128) NULL DEFAULT NULL,				
				`meta` TEXT NOT NULL,
				`setting_data` TEXT NOT NULL,
				PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8;"));
		}
		/**
		 * tables rows
		 */
		if (!dbTbp::exist("@__rows")) {
			dbDelta(dbTbp::prepareQuery("CREATE TABLE IF NOT EXISTS `@__rows` (
				`id` INT(11) NOT NULL AUTO_INCREMENT,
				`table_id` VARCHAR(128) NULL DEFAULT NULL,				
				`data` TEXT NOT NULL,
				PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8;"));
		}
		/**
		* Plugin usage statisttbp
		*/
		if(!dbTbp::exist("@__usage_stat")) {
			dbDelta(dbTbp::prepareQuery("CREATE TABLE `@__usage_stat` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `code` varchar(64) NOT NULL,
			  `visits` int(11) NOT NULL DEFAULT '0',
			  `spent_time` int(11) NOT NULL DEFAULT '0',
			  `modify_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			  UNIQUE INDEX `code` (`code`),
			  PRIMARY KEY (`id`)
			) DEFAULT CHARSET=utf8"));
			dbTbp::query("INSERT INTO `@__usage_stat` (code, visits) VALUES ('installed', 1)");
		}
		installerDbUpdaterTbp::runUpdate();
		if($current_version && !self::$_firstTimeActivated) {
			self::setUsed();
			// For users that just updated our plugin - don't need tp show step-by-step tutorial
			update_user_meta(get_current_user_id(), TBP_CODE . '-tour-hst', array('closed' => 1));
		}
		update_option($wpPrefix. TBP_DB_PREF. 'db_version', TBP_VERSION);
		add_option($wpPrefix. TBP_DB_PREF. 'db_installed', 1);
	}
	static public function setUsed() {
		update_option(TBP_DB_PREF. 'plug_was_used', 1);
	}
	static public function isUsed() {
		return true;	// No welcome page for now
		//return 0;
		return (int) get_option(TBP_DB_PREF. 'plug_was_used');
	}
	static public function delete() {
		self::_checkSendStat('delete');
		global $wpdb;
		$wpPrefix = $wpdb->prefix;
		$wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.TBP_DB_PREF."modules`");
		$wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.TBP_DB_PREF."modules_type`");
		$wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.TBP_DB_PREF."usage_stat`");
		$wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.TBP_DB_PREF."tables`");
		$wpdb->query("DROP TABLE IF EXISTS `".$wpPrefix.TBP_DB_PREF."rows`");
		delete_option($wpPrefix. TBP_DB_PREF. 'db_version');
		delete_option($wpPrefix. TBP_DB_PREF. 'db_installed');
	}
	static public function deactivate() {
		self::_checkSendStat('deactivate');
	}
	static private function _checkSendStat($statCode) {
		if(class_exists('frameTbp') 
			&& frameTbp::_()->getModule('supsystic_promo')
			&& frameTbp::_()->getModule('options')
		) {
			frameTbp::_()->getModule('supsystic_promo')->getModel()->saveUsageStat( $statCode );
			frameTbp::_()->getModule('supsystic_promo')->getModel()->checkAndSend( true );
		}
	}
	static public function update() {
		global $wpdb;
		$wpPrefix = $wpdb->prefix; /* add to 0.0.3 Versiom */
		$currentVersion = get_option($wpPrefix. TBP_DB_PREF. 'db_version', 0);
		if(!$currentVersion || version_compare(TBP_VERSION, $currentVersion, '>')) {
			self::init( true );
			update_option($wpPrefix. TBP_DB_PREF. 'db_version', TBP_VERSION);
		}
	}


}
