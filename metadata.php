<?php
/**
 * @abstract
 * @author 	Gregor Wendland <oxid@gregor-wendland.com>
 * @copyright Copyright (c) 2022, Gregor Wendland
 * @package gw
 * @version 2022-02-14
 */

/**
 * Metadata version
 */
	$sMetadataVersion = '2.1'; // see https://docs.oxid-esales.com/developer/en/6.1/modules/skeleton/metadataphp/version21.html

/**
 * Module information
 */
$aModule = array(
    'id'           => 'gw_oxid_newsletter_registration_extended',
    'title'        => 'Erweiterte Newsletter-Anmeldung',
//     'thumbnail'    => 'out/admin/img/logo.jpg',
    'version'      => '1.0',
    'author'       => 'Gregor Wendland',
    'email'		   => 'oxid@gregor-wendland.com',
    'url'		   => 'https://www.gregor-wendland.com',
    'description'  => array(
    	'de'		=> 'Erweitert die Newsletter-Anmeldung mit folgenden Funktionen:
			<ul>
				<li>
					Nach erfolgreicher, vollständiger Anmeldung zum Newsletter wird kann eine weitere E-Mail geschickt werden, "Willkommen zum Newsletter von XY".
				</li>
			</ul>',
    ),
    'extend'       => array(
		OxidEsales\Eshop\Application\Controller\NewsletterController::class => gw\gw_oxid_newsletter_registration_extended\Application\Controller\NewsletterController::class,
		OxidEsales\Eshop\Core\Email::class => gw\gw_oxid_newsletter_registration_extended\Core\Email::class,
	),
	'controllers'  => [
	],
    'settings' => [
	],
	'blocks' => array(
	),
	'events'       => array(
		'onActivate'   => '\gw\gw_oxid_newsletter_registration_extended\Core\Events::onActivate',
		'onDeactivate' => '\gw\gw_oxid_newsletter_registration_extended\Core\Events::onDeactivate'
	),
	'templates' => [
		// frontend
		'email/html/gw_oxid_newsletter_registration_welcome.tpl' => 'gw/gw_oxid_newsletter_registration_extended/Application/views/tpl/email/html/gw_oxid_newsletter_registration_welcome.tpl',
		'email/plain/gw_oxid_newsletter_registration_welcome.tpl' => 'gw/gw_oxid_newsletter_registration_extended/Application/views/tpl/email/plain/gw_oxid_newsletter_registration_welcome.tpl',
	]
);
?>
