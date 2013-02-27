<?php

// Load Stripe library
require 'lib/Stripe.php';

// Load configuration settings
require 'config.php';

// Force https
if( $_SERVER["HTTPS"] != "on" && !$config['test-mode'] ) {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: https://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
	exit();
}

if ($_POST) {
	Stripe::setApiKey($config['secret-key']);

	// POSTed Variables
	$token = $_POST['stripeToken'];
	$first_name = $_POST['first-name'];
	$last_name 	= $_POST['last-name'];
	$name 			= $first_name . ' ' . $last_name;
	$address = $_POST['address']."\n" . $_POST['city'] . ', ' . $_POST['state'] . ' ' . $_POST['zip'];
	$email   = $_POST['email'];
	$phone   = $_POST['phone'];
	$amount  = (float) $_POST['amount'];

	try {
		if ( ! isset($_POST['stripeToken']) ) {
			throw new Exception("The Stripe Token was not generated correctly");
		}

		// Charge the card
		$donation = Stripe_Charge::create(array(
			'card' => $token,
			'description' => 'Donation by ' . $name . ' (' . $email . ')',
			'amount' => $amount * 100,
			'currency' => 'usd')
		);

		// Build and send the email
		$headers = "From: " . $config['emaily-from'];
		$headers .= "\r\nBcc: " . $config['emaily-bcc'] . "\r\n\r\n";

		// Find and replace values
		$find = array('%name%', '%amount%');
		$replace = array($name, '$' . $amount);

		$message = str_replace($find, $replace , $config['email-message']) . "\n\n";
		$message .= "Amount: $" . $amount . "\n";
		$message .= "Address: " . $address . "\n";
		$message .= "Phone: " . $phone . "\n";
		$message .= "Email: " . $email . "\n";
		$message .= "Date: " . date('M j, Y, g:ia', $donation['created']) . "\n";
		$message .= "Transaction ID: " . $donation['id'] . "\n\n\n";

		$subject = $config['email-subject'];

		// Send it
		if ( !$config['test-mode'] ) {
			mail($email,$subject,$message,$headers);
		}

		// Forward to "Thank You" page
		header('Location: ' . $config['thank-you']);
		exit;

	}
	catch (Exception $e) {
		$error = $e->getMessage();
	}
}

?>  
