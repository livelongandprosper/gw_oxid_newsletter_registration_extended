<?php
namespace gw\gw_oxid_newsletter_registration_extended\Application\Controller;

/**
 * Extend NewsletterController.
 */
class NewsletterController extends NewsletterController_parent {

	/**
	 * Extend addme function to send a welcome to newsletter email.
	 */
	public function addme() {
		parent::addme();

		if($this->getNewsletterStatus() == 2) {

			$oUser = oxNew(\OxidEsales\Eshop\Application\Model\User::class);
	        if ($oUser->load(\OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('uid'))) {
				$oEmail = oxNew(\OxidEsales\Eshop\Core\Email::class);
				$oEmail->sendNewsletterWelcomeMail($oUser);
			}
		}
	}

}
?>
