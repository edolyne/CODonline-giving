<?php

return $config = Array(

	// Enable test mode (not require HTTPS)
	'test-mode'  => true,

	// Secret Key from Stripe.com Dashboard
	'secret-key' => 'sk_test_EGTZ4t67SbqW31VZszme81c0',

	// Publishable Key from Stripe.com Dashboard
	'publishable-key' => 'pk_test_srNmP1O6mYpFDQ1nmAAl78SU',

	// Where to send upon successful donation (must include http://)
	'thank-you'  => 'http://churchoftheopendoorct.org/thank-you	',

	// Who the email will be from.
	'email-from' => 'connect@churchoftheopendoorct.org',

	// Who should be BCC'd on this email. Probably an administrative email.
	'email-bcc'  => 'connect@churchoftheopendoorct.org',

	// Subject of email receipt
	'email-subject' => 'Thank you for your donation!',

	// Email message. %name% is the donor's name. %amount% is the donation amount
	'email-message' => "Dear %name%,\n\nThank you for your donation of %amount%. We rely on the financial support from people like you to keep our cause alive. Below is your donation receipt to keep for your records."

);
