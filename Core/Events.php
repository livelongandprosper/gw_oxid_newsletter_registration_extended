<?php
	namespace gw\gw_oxid_newsletter_registration_extended\Core;

	use OxidEsales\Eshop\Core\DbMetaDataHandler;
	use OxidEsales\Eshop\Core\DatabaseProvider;

	class Events {
		/**
		 * add_db_key function.
		 *
		 * @access private
		 * @static
		 * @param mixed $table_name
		 * @param mixed $keyname
		 * @param mixed $column_names
		 * @param bool $unique (default: false)
		 * @return void
		 */
		private static function add_db_key($table_name, $keyname, $column_names, $unique=false) {
			// create key
			if($unique) {
				DatabaseProvider::getDb()->execute("
					ALTER TABLE  `$table_name` ADD UNIQUE  `$keyname` (  `".implode('`,`', $column_names)."` );
				");
			} else {
				DatabaseProvider::getDb()->execute("
					ALTER TABLE  `$table_name` ADD INDEX `$keyname` (  `".implode('`,`', $column_names)."` ) ;
				");
			}
		}

		/**
		 * @param $table_name
		 * @param $column_name
		 * @param $datatype
		 */
		private static function add_db_field($table_name, $column_name, $datatype) {
			$gw_head_exists = DatabaseProvider::getDb()->GetOne("SHOW COLUMNS FROM `$table_name` LIKE '$column_name'");
			if(!$gw_head_exists) {
				DatabaseProvider::getDb()->execute(
					"ALTER TABLE `$table_name` ADD `$column_name` $datatype;"
				);
			}
		}

		/**
		 * Execute some things while activating the module.
		 */
		public static function onActivate() {
			$config = \OxidEsales\Eshop\Core\Registry::getConfig();
			try {
//				self::add_db_field('oxorder', 'gw_cutomer_feedback', "TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL COMMENT 'customer feedback'");
			}	catch (OxidEsales\Eshop\Core\Exception\DatabaseErrorException $e) {
				// do nothing... php will ignore and continue
			}

			DatabaseProvider::getDb()->execute("
				INSERT INTO
					oxcontents
				SET
					OXID = '7be6430ece958b8aa4f0d0708c3ba186',
					OXLOADID = 'gw_nl_welcome_text_html',
					OXSHOPID = '".$config->getShopId()."',
					OXSNIPPET = 1,
					OXACTIVE = 1,
					OXTITLE = 'Newsletter Wilkommen-E-Mail HTML',
					OXCONTENT = '<p>Du bist nun zum Newsletter angemeldet.<br></p>',
					OXACTIVE_1 = 1,
					OXTITLE_1 = 'Newsletter Welcome email HTML',
					OXCONTENT_1 = '<p>You are now registered to our newsletter.<br></p>',
					OXFOLDER = 'CMSFOLDER_EMAILS'
				ON DUPLICATE KEY UPDATE
					OXLOADID = 'gw_nl_welcome_text_html'
				;
			");

			DatabaseProvider::getDb()->execute("
				INSERT INTO
					oxcontents
				SET
					OXID = '4e27fb7cbfc2ce354b6dea6396349aea',
					OXLOADID = 'gw_nl_welcome_text_plain',
					OXSHOPID = '".$config->getShopId()."',
					OXSNIPPET = 1,
					OXACTIVE = 1,
					OXTITLE = 'Newsletter Wilkommen-E-Mail Plain',
					OXCONTENT = 'Du bist nun zum Newsletter angemeldet.',
					OXACTIVE_1 = 1,
					OXTITLE_1 = 'Newsletter Welcome email plain',
					OXCONTENT_1 = 'You are now registered to our newsletter.',
					OXFOLDER = 'CMSFOLDER_EMAILS'					
				ON DUPLICATE KEY UPDATE
					OXLOADID = 'gw_nl_welcome_text_plain'
				;
			");

			$oDbMetaDataHandler = oxNew(DbMetaDataHandler::class);
			$oDbMetaDataHandler->updateViews();
		}
		public static function onDeactivate() {
			$config = \OxidEsales\Eshop\Core\Registry::getConfig();
			DatabaseProvider::getDb()->execute("DELETE FROM oxtplblocks WHERE oxshopid='".$config->getShopId()."' AND oxmodule='gw_oxid_newsletter_registration_extended';");
			// DatabaseProvider::getDb()->execute("ALTER TABLE oxvoucherseries DROP INDEX gw_oxid_newsletter_registration_extended;");
			exec( "rm -f " .$config->getConfigParam( 'sCompileDir' )."/smarty/*" );
			exec( "rm -Rf " .$config->getConfigParam( 'sCompileDir' )."/*" );
			$oDbMetaDataHandler = oxNew(DbMetaDataHandler::class);
			$oDbMetaDataHandler->updateViews();
		}
	}
?>
