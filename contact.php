<?php
if ($_POST) { 
	$arrEmail = array('gary@bulkofficesupply.com', 'alex@bulkofficesupply.com'); // contact@usp.com
	$email_from = 'bulkofficesupply.com';
	$email_name = 'Aeramax Inquiry';
	$name = htmlspecialchars($_POST["First_Name"]); 
	$lastname = htmlspecialchars($_POST["Last_Name"]); 
	$email = htmlspecialchars($_POST["Email"]);
	$phone = htmlspecialchars($_POST["Phone_Part_1"]. '-' . $_POST["Phone_Part_2"] . '-' . $_POST["Phone_Part_3"]);
	$building = htmlspecialchars($_POST["Type_Of_Building"]);
	$rooms = htmlspecialchars($_POST["Number_Of_Rooms"]);
	$subject = $email_name;
	$json = array(); // array for response

	function mime_header_encode($str, $data_charset, $send_charset) { // function for changing headers in the right coding format 
		if($data_charset != $send_charset)
			$str=iconv($data_charset,$send_charset.'//IGNORE',$str);
		return ('=?'.$send_charset.'?B?'.base64_encode($str).'?=');
	}
	/* class for sending message in the right coding format */
	class TEmail {
		public $from_email;
		public $from_name;
		public $to_email;
		public $to_name;
		public $subject;
		public $data_charset='UTF-8';
		public $send_charset='UTF-8';
		public $body='';
		public $type='text/html';

		function send(){
			$dc=$this->data_charset;
			$sc=$this->send_charset;
			$enc_to=mime_header_encode($this->to_name,$dc,$sc).' <'.$this->to_email.'>';
			$enc_subject=mime_header_encode($this->subject,$dc,$sc);
			$enc_from=mime_header_encode($this->from_name,$dc,$sc).' <'.$this->from_email.'>';
			$enc_body=$dc==$sc?$this->body:iconv($dc,$sc.'//IGNORE',$this->body);
			$headers='';
			$headers.="Mime-Version: 1.0\r\n";
			$headers.="Content-type: ".$this->type."; charset=".$sc."\r\n";
			$headers.="From: ".$enc_from."\r\n";
			return mail($enc_to,$enc_subject,$enc_body,$headers);
		}

	}

	// $message = '<html><body>';
	$message = '
	<table rules="all" align="center" border="1" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 600px; min-width: 280px; border-color: #1C7BA7">
		<tr>
			<td colspan="2" align="center" bgcolor="#1C7BA7" style="padding: 40px 0 30px 0;">
				<h1 style="color: #ffffff;">Aeramax Inquiry</h1>
			</td>
		</tr>
		<tr>
			<td style="border: none; padding: 20px 5px 5px; vertical-align: top; width: 50%; text-align: right;">
				<strong>Full Name:</strong>
			</td>
			<td style="border: none; padding: 20px 5px 5px; vertical-align: top; width: 50%;">' . $name . ' ' . $lastname . '</td>
		</tr>
		<tr>
			<td style="border: none; padding: 5px; vertical-align: top; width: 50%; text-align: right;">
				<strong>Email:</strong>
			</td>
			<td style="border: none; padding: 5px; vertical-align: top; width: 50%;"> <a target="_parent" href="mailto:'.$email.'">' . $email . '</a></td>
		</tr>
		<tr>
			<td style="border: none; padding: 5px; vertical-align: top; width: 50%; text-align: right;">
				<strong>Phone:</strong>
			</td>
			<td style="border: none; padding: 5px; vertical-align: top; width: 50%;">' . $phone . '</td>
		</tr>
		<tr>
			<td style="border: none; padding: 5px; vertical-align: top; width: 50%; text-align: right;">
				<strong>Type of Building:</strong>
			</td>
			<td style="border: none; padding: 5px; vertical-align: top; width: 50%;">' . $building . '</td>
		</tr>
		<tr>
			<td style="border: none; padding: 5px 5px 20px; vertical-align: top; width: 50%; text-align: right;">
				<strong>Number of Rooms in Building:</strong>
			</td>
			<td style="border: none; padding: 5px 5px 20px; vertical-align: top; width: 50%;">' . $rooms . '</td>
		</tr>
	</table>';
	// $message .= "</body></html>";

	foreach($arrEmail as $key => $email_to) {

	$emailgo= new TEmail; // initialize class for sending message
	$emailgo->from_email= $email_from;
	$emailgo->from_name= $email_name;
	$emailgo->to_email= $email_to;
	$emailgo->to_name= $email_name;
	$emailgo->subject= $subject; // email subject
	$emailgo->body= $message;
	$emailgo->send();
	}

	$json['error'] = 0; // if no errors

	echo json_encode($json); // response array
} else { // if POST array has not been sent
	echo 'GET LOST!'; // then send
}

?>