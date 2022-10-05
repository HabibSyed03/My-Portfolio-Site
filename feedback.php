<?php /*

	IMPORTANT: If you see this notice in your web browser when you
	test your feedback form, it means that your web host does not
	have PHP set up correctly, even if they tell you they have.
	This is a PHP script, which means your web server must have PHP
	installed for it to work. You should *never* be able to see this
	notice in a browser on a website with a working PHP system,
	not even when you use "View Source" in your browser.


	CHFEEDBACK.PHP Feedback Form PHP Script
	Generated by thesitewizard.com's Feedback Form Wizard 3.1.0.
	Copyright 2000-2021 by Christopher Heng. All rights reserved.
	thesitewizard is a trademark of Christopher Heng.

	Get the latest version, free, from:
		https://www.thesitewizard.com/wizards/feedbackform.shtml

	You can read the Frequently Asked Questions (FAQ) at:
		https://www.thesitewizard.com/faqs/feedbackform.shtml

	I can be contacted at:
		https://www.thesitewizard.com/feedback.php
	Note that I do not have the time to respond to questions
	that have already been answered in the FAQ, so *please* read
	the FAQ.

	LICENCE TERMS

	1. You may use this script on your website, with or
	without modifications, free of charge.

	2. You may NOT distribute or republish this script,
	whether modified or not. The script can only be
	distributed by the author, Christopher Heng.

	3. THE SCRIPT AND ITS DOCUMENTATION ARE PROVIDED
	"AS IS", WITHOUT WARRANTY OF ANY KIND, NOT EVEN THE
	IMPLIED WARRANTY OF MERCHANTABILITY OR FITNESS FOR A
	PARTICULAR PURPOSE. YOU AGREE TO BEAR ALL RISKS AND
	LIABILITIES ARISING FROM THE USE OF THE SCRIPT,
	ITS DOCUMENTATION AND THE INFORMATION PROVIDED BY THE
	SCRIPTS AND THE DOCUMENTATION.

	If you cannot agree to any of the above conditions, you
	may not use the script. 

	Although it is not required, I will be most grateful
	if you could also link to https://www.thesitewizard.com/

	Please do not remove any of the above. It will help you
	years down the road when you have forgotten how you got
	this script but need to update it or get help. Don't worry.
	If your web host has installed PHP correctly on their
	system, neither this notice nor anything you see below
	will ever be sent to your visitor's web browser. */

// ------------- CONFIGURABLE SECTION ------------------------

$mailto = 'Habib.syed@ontariotechu.net' ;
$subject = "Feedback Form" ;
$formurl = "http://C:\\Users\\habib\\Desktop\\WebDevelopmentCourse\\feedback.html" ;
$thankyouurl = "http://C:\\Users\\habib\\Desktop\\WebDevelopmentCourse\\thankyou.html" ;
$errorurl = "http://C:\\Users\\habib\\Desktop\\WebDevelopmentCourse\\error.html" ;
$want_tel_field = 0;
$want_addr_field = 0;

$email_is_required = 1;
$name_is_required = 1;
$comments_is_required = 1;
$uself = 0;
$use_envsender = 0;
$use_sendmailfrom = 0;
$smtp_server_win = '' ;
$use_webmaster_email_for_from = 0;


// -------------------- END OF CONFIGURABLE SECTION ---------------

define( 'MAX_LINE_LENGTH', 998 );
define( 'CONTENT_TYPE', 'Content-Type: text/plain; charset="utf-8"' );

$linesep = $uself ? "\n" : "\r\n" ;
if ($use_sendmailfrom) {
	ini_set( 'sendmail_from', $mailto );
}
if (strlen($smtp_server_win)) {
	ini_set( 'SMTP', $smtp_server_win );
}
$envsender = "-f$mailto" ;
$fullname = trim($_POST['fullname']) ;
$email = trim($_POST['email']) ;
$comments = $uself ? preg_replace( '/\r\n/', "\n", $_POST['comments'] ) : $_POST['comments'] ;
$http_referrer = $_SERVER['HTTP_REFERER'];

if (!isset($_POST['email'])) {
	header( "Location: $formurl" );
	exit ;
}
if (($email_is_required && (empty($email) || (substr_count($email,'@') != 1))) || (strlen($email) > 254) || preg_match("/[\s<>,;'\"]/", $email) ||
	($name_is_required && empty($fullname)) || (strlen($fullname) > 729) || preg_match("/[\r\n@<>,;\"]/", $fullname) ||
	($comments_is_required && empty($comments))) {
	header( "Location: $errorurl" );
	exit ;
}

if (empty($email)) {
	$email = $mailto ;
}
$fromemail = $use_webmaster_email_for_from ? $mailto : $email ;
$opt_flds = $want_addr_field ? "Address: " . $_POST['addr'] . $linesep : '' ;
$opt_flds .= $want_tel_field ? "Telephone: " . $_POST['tel'] . $linesep : '' ;
$messageproper =
	"This message was sent from:" . $linesep .
	$http_referrer . $linesep .
	"------------------------------------------------------------" . $linesep .
	"Name of sender: $fullname" . $linesep .
	"Email of sender: $email" . $linesep .
	$opt_flds .
	"------------------------- COMMENTS -------------------------" . $linesep . $linesep .
	$comments . $linesep . $linesep .
	"------------------------------------------------------------" . $linesep ;
$messageproper = wordwrap( $messageproper, MAX_LINE_LENGTH, $linesep, true ) ;

$headers =
	"From: \"$fullname\" <$fromemail>" . $linesep . "Reply-To: \"$fullname\" <$email>" . $linesep . "X-Mailer: chfeedback.php 3.1.0" .
	$linesep . 'MIME-Version: 1.0' . $linesep . CONTENT_TYPE ;

if ($use_envsender && !ini_get('safe_mode')) {
	mail($mailto, $subject, $messageproper, $headers, $envsender );
}
else {
	mail($mailto, $subject, $messageproper, $headers );
}
header( "Location: $thankyouurl" );
exit ;

?>

