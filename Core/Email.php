<?php
namespace gw\gw_oxid_newsletter_registration_extended\Core;

class Email extends Email_parent {

	/**
	 * Newsletter welcome mail template
	 *
	 * @var string
	 */
	protected $_sNewsletterWelcomeTemplate = "email/html/gw_oxid_newsletter_registration_welcome.tpl";

	/**
	 * Newsletter welcome plain mail template
	 *
	 * @var string
	 */
	protected $_sNewsletterWelcomeTemplatePlain = "email/plain/gw_oxid_newsletter_registration_welcome.tpl";

	/**
	 * Sets mailer additional settings and sends "newsletter" mail to user.
	 * Returns true on success.
	 *
	 * @param \OxidEsales\Eshop\Application\Model\Newsletter $newsLetter newsletter object
	 * @param \OxidEsales\Eshop\Application\Model\User       $user       user object
	 * @param string                                         $subject    user defined subject [optional]
	 *
	 * @return bool
	 */
	public function sendNewsletterWelcomeMail($user, $subject = null)
	{
		// shop info
		$shop = $this->_getShop();

		//set mail params (from, fromName, smtp)
		$this->_setMailParams($shop);

		// create messages
		$smarty = $this->_getSmarty();
		$this->setUser($user);

		// Process view data array through oxOutput processor
		$this->_processViewArray();

		$this->setBody($smarty->fetch($this->_sNewsletterWelcomeTemplate));
		$this->setAltBody($smarty->fetch($this->_sNewsletterWelcomeTemplatePlain));
		$this->setSubject(($subject !== null) ? $subject : \OxidEsales\Eshop\Core\Registry::getLang()->translateString("GW_NEWSLETTER_WELCOME") . " " . $shop->oxshops__oxname->getRawValue());

		$fullName = $user->oxuser__oxfname->getRawValue() . " " . $user->oxuser__oxlname->getRawValue();

		$this->setRecipient($user->oxuser__oxusername->value, $fullName);
		$this->setFrom($shop->oxshops__oxinfoemail->value, $shop->oxshops__oxname->getRawValue());
		$this->setReplyTo($shop->oxshops__oxinfoemail->value, $shop->oxshops__oxname->getRawValue());

		return $this->send();
	}

}
?>
