<?php

use Config\Services;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!function_exists('send_html_email')) {
	
 	
	function send_html_email($emailProperties)
	{
		//$config['protocol'] = 'sendmail';
		$config['protocol'] = getenv('email.protocol');
		$config['charset'] = 'utf-8';
		//$config['mailPath'] = '/usr/sbin/sendmail';
		//$config['wordWrap'] = true;
		$config['mailType'] = 'html';
		$config['CRLF'] = '\r\n';

		$email = new PHPMailer(true);

		//$email = \Config\Services::email($config);

		if (isset($emailProperties['to'])) {
			$email->addAddress($emailProperties['to']);
		}

		if (isset($emailProperties['cc'])) {
			$email->addCC($emailProperties['cc']);
		}

		if (isset($emailProperties['bcc'])) {
			$email->addBCC($emailProperties['bcc']);
		}

		if (isset($emailProperties['subject'])) {
			$email->Subject = $emailProperties['subject'];
		}

		if (isset($emailProperties['content'])) {
			$email->Body = $emailProperties['content'];
		}

		if ($emailProperties['from'] != '' && $emailProperties['from_name'] != '') {
			$email->setFrom($emailProperties['from'], $emailProperties['from_name']);
		}
		
		$email->isHTML(true);
		$email->CharSet = 'UTF-8';
		//d($email);exit;

		if (!$email->send()) {
			// Fetch the email errors
			return $email->ErrorInfo;
		}

		return true;
	}
}
