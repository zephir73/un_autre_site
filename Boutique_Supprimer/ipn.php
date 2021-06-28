<?php
//Payment Information
	$payment_type = "";
	$payment_date = "";
	$payment_status = "";
//Buyer Information
	$address_status = "";
	$payer_status = "";
	$first_name = "";
	$last_name = "";
	$payer_email = "";
	$payer_id = "";
	$address_name = "";
	$address_country = "";
	$address_country_code = "";
	$address_zip = "";
	$address_state = "";
	$address_city = "";
	$address_street = "";
//Basic Information
	$business = "";
	$receiver_email = "";
	$receiver_id = "";
	$residence_country = "";
	$item_name1 = "";
	$list_item_name = array();
	$item_number1 = "";
	$list_item_number = array();
	$quantity = "";
    $list_item_quantity = array();
	$tax = "";
//Currency and Currrency Exchange
	$mc_currency = "";
	$mc_fee = "";
	$mc_gross_1 = "";
	$mc_handling = "";
	$mc_handling1 = "";
	$mc_shipping = "";
	$mc_shipping1 = "";
//Transaction Fields
	$txn_type = "";
	$txn_id = "";// numero de la transaction
	$notify_version = "";
	$receipt_ID = "";
//Advanced and Custom Information
	$custom = "";
	$invoice = "";


/*// variables
$item_name = $_POST['item_name'];
$item_name1 = $_POST['item_name1'];
$item_name2 = $_POST['item_name2'];
$item_name3 = $_POST['item_name3'];
$item_name4 = $_POST['item_name4'];
$item_name5 = $_POST['item_name5'];
$item_number = $_POST['item_number'];
$item_number1 = $_POST['item_number1'];
$item_number2 = $_POST['item_number2'];
$item_number3 = $_POST['item_number3'];
$item_number4 = $_POST['item_number4'];
$item_number5 = $_POST['item_number5'];
$quantity = $_POST['quantity'];
$quantity1 = $_POST['quantity1'];
$quantity2 = $_POST['quantity2'];
$quantity3 = $_POST['quantity3'];
$quantity4 = $_POST['quantity4'];
$quantity5 = $_POST['quantity5'];
$business = $_POST['business'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$mc_gross = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$receiver_id = $_POST['receiver_id'];
$quantity = $_POST['quantity'];
$num_cart_items = $_POST['num_cart_items'];
$payment_date = $_POST['payment_date'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$payment_type = $_POST['payment_type'];
$payment_status = $_POST['payment_status'];
$payment_gross = $_POST['payment_gross'];
$payment_fee = $_POST['payment_fee'];
$settle_amount = $_POST['settle_amount'];
$memo = $_POST['memo'];
$payer_email = $_POST['payer_email'];
$txn_type = $_POST['txn_type'];
$payer_status = $_POST['payer_status'];
$address_name = $_POST['address_name'];
$address_street = $_POST['address_street'];
$address_city = $_POST['address_city'];
$address_state = $_POST['address_state'];
$address_zip = $_POST['address_zip'];
$address_country = $_POST['address_country'];
$address_status = $_POST['address_status'];
$item_number = $_POST['item_number'];
$tax = $_POST['tax'];
$option_name1 = $_POST['option_name1'];
$option_selection1 = $_POST['option_selection1'];
$option_name2 = $_POST['option_name2'];
$option_selection2 = $_POST['option_selection2'];
$for_auction = $_POST['for_auction'];
$invoice = $_POST['invoice'];
$custom = $_POST['custom'];
$notify_version = $_POST['notify_version'];
$verify_sign = $_POST['verify_sign'];
$payer_business_name = $_POST['payer_business_name'];
$payer_id =$_POST['payer_id'];
$mc_currency = $_POST['mc_currency'];
$mc_fee = $_POST['mc_fee'];
$exchange_rate = $_POST['exchange_rate'];
$settle_currency  = $_POST['settle_currency'];
$parent_txn_id  = $_POST['parent_txn_id'];*/

/*
 * Read POST data
 * reading posted data directly from $_POST causes serialization
 * issues with array data in POST.
 * Reading raw POST data from input stream instead.
 */        
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
    $keyval = explode ('=', $keyval);
    if (count($keyval) == 2)
        $myPost[$keyval[0]] = urldecode($keyval[1]);
}
// Read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
    $get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
    if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
        $value = urlencode(stripslashes($value));
    } else {
        $value = urlencode($value);
    }
    $req .= "&$key=$value";
}
/*
 * Post IPN data back to PayPal to validate the IPN data is genuine
 * Without this step anyone can fake IPN data
 */
$paypalURL = "https://www.sandbox.paypal.com/cgi-bin/webscr";
$ch = curl_init($paypalURL);
if ($ch == FALSE) {
    return FALSE;
}
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSLVERSION, 6);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
// Set TCP timeout to 30 seconds
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: company-name'));
$res = curl_exec($ch);
/*
 * Inspect IPN validation result and act accordingly
 * Split response headers and payload, a better way for strcmp
 */ 
$tokens = explode("\r\n\r\n", trim($res));
$res = trim(end($tokens));
if (strcmp($res, "VERIFIED") == 0 || strcasecmp($res, "VERIFIED") == 0) 
{
    //Payment Information
	if(isset($_POST['payment_type']))
	{
		$payment_type = $_POST['payment_type'];
	}
	else
	{
		$payment_type = 'vide';
	}
	if(isset($_POST['payment_date']))
	{
		$payment_date = $_POST['payment_date'];
	}
	else
	{
		$payment_date = 'vide';
	}
	if(isset($_POST['payment_status']))
	{
		$payment_status = $_POST['payment_status'];
	}
	else
	{
		$payment_status = 'vide';
	}
	//Buyer Information
	if(isset($_POST['address_status']))
	{
		$address_status = $_POST['address_status'];
	}
	else
	{
		$address_status = 'vide';
	}
	if(isset($_POST['payer_status']))
	{
		$payer_status = $_POST['payer_status'];
	}
	else
	{
		$payer_status = 'vide';
	}
	if(isset($_POST['first_name']))
	{
		$first_name = $_POST['first_name'];// nom de famille
	}
	else
	{
		$first_name = 'vide';
	}
	if(isset($_POST['last_name']))
	{
		$last_name = $_POST['last_name'];// prenom
	}
	else
	{
		$last_name = 'vide';
	}
	if(isset($_POST['payer_email']))
	{
		$payer_email = $_POST['payer_email'];
	}
	else
	{
		$payer_email = 'vide';
	}
	if(isset($_POST['payer_id']))
	{
		$payer_id = $_POST['payer_id'];
	}
	else
	{
		$payer_id = 'vide';
	}
	if(isset($_POST['address_name']))
	{
		$address_name = $_POST['address_name'];
	}
	else
	{
		$address_name = 'vide';
	}
	if(isset($_POST['address_country']))
	{
		$address_country = $_POST['address_country'];
	}
	else
	{
		$address_country = 'vide';
	}
	if(isset($_POST['address_country_code']))
	{
		$address_country_code = $_POST['address_country_code'];
	}
	else
	{
		$address_country_code = 'vide';
	}
	if(isset($_POST['address_zip']))
	{
		$address_zip = $_POST['address_zip'];
	}
	else
	{
		$address_zip = 'vide';
	}
	if(isset($_POST['address_state']))
	{
		$address_state = $_POST['address_state'];
	}
	else
	{
		$address_state = 'vide';
	}
	if(isset($_POST['address_city']))
	{
		$address_city = $_POST['address_city'];
	}
	else
	{
		$address_city = 'vide';
	}
	if(isset($_POST['address_street']))
	{
		$address_street = $_POST['address_street'];
	}
	else
	{
		$address_street = 'vide';
	}
	//Basic Information
	if(isset($_POST['business']))
	{
		$business = $_POST['business'];
	}
	else
	{
		$business = 'vide';
	}
	if(isset($_POST['receiver_email']))
	{
		$receiver_email = $_POST['receiver_email'];
	}
	else
	{
		$receiver_email = 'vide';
	}
	if(isset($_POST['receiver_id']))
	{
		$receiver_id = $_POST['receiver_id'];
	}
	else
	{
		$receiver_id = 'vide';
	}
	if(isset($_POST['residence_country']))
	{
		$residence_country = $_POST['residence_country'];
	}
	else
	{
		$residence_country = 'vide';
	}
	if(isset($_POST['item_name1']))
	{
		$item_name1 = $_POST['item_name1'];

		$x=1;// item_name0 n'existe pas
		while (isset($_POST['item_name'.$x.'']))
        {
            array_push($list_item_name,$_POST['item_name'.$x.'']);
            $x++;
        }
	}
	else
	{
		$item_name1 = 'vide';	
	}
	if(isset($_POST['item_number1']))
	{
		$item_number1 = $_POST['item_number1'];

        $x=1;// item_number0 n'existe pas
        while (isset($_POST['item_number'.$x.'']))
        {
            array_push($list_item_number,$_POST['item_number'.$x.'']);
            $x++;
        }
	}
	else
	{
		$item_number1 = 'vide';
	}
	if(isset($_POST['quantity1']))
	{
		$quantity = $_POST['quantity1'];

        $x=1;// quantity 0 n'existe pas
        while (isset($_POST['quantity'.$x.'']))
        {
            array_push($list_item_quantity,$_POST['quantity'.$x.'']);
            $x++;
        }
	}
	else
	{
		$quantity = 'vide';
	}
	if(isset($_POST['tax']))
	{
		$tax = $_POST['tax'];
	}
	else
	{
		$tax = 'vide';
	}
	//Currency and Currrency Exchange
	if(isset($_POST['mc_currency']))
	{
		$mc_currency = $_POST['mc_currency'];
	}
	else
	{
		$mc_currency = 'vide';
	}
	if(isset($_POST['mc_fee']))
	{
		$mc_fee = $_POST['mc_fee'];
	}
	else
	{
		$mc_fee = 'vide';
	}
	if(isset($_POST['mc_gross_1']))
	{
		$mc_gross_1 = $_POST['mc_gross_1'];
	}
	else
	{
		$mc_gross_1 = 'vide';
	}
	if(isset($_POST['mc_handling']))
	{
		$mc_handling = $_POST['mc_handling'];
	}
	else
	{
		$mc_handling = 'vide';
	}
	if(isset($_POST['mc_handling1']))
	{
		$mc_handling1 = $_POST['mc_handling1'];
	}
	else
	{
		$mc_handling1 = 'vide';
	}
	if(isset($_POST['mc_shipping']))
	{
		$mc_shipping = $_POST['mc_shipping'];
	}
	else
	{
		$mc_shipping = 'vide';
	}
	if(isset($_POST['mc_shipping1']))
	{
		$mc_shipping1 = $_POST['mc_shipping1'];
	}
	else
	{
		$mc_shipping1 = 'vide';
	}
	//Transaction Fields
	if(isset($_POST['txn_type']))
	{
		$txn_type = $_POST['txn_type'];	
	}
	else
	{
		$txn_type = 'vide';	
	}
	if(isset($_POST['txn_id']))
	{
		$txn_id = $_POST['txn_id'];
	}
	else
	{
		$txn_id = 'vide';
	}
	if(isset($_POST['notify_version']))
	{
		$notify_version = $_POST['notify_version'];
	}
	else
	{
		$notify_version = 'vide';
	}
	if(isset($_POST['receiver_id']))
	{
		$receipt_ID = $_POST['receiver_id'];
	}
	else
	{
		$receipt_ID = 'vide';
	}
	//Advanced and Custom Information
	if(isset($_POST['custom']))
	{
		$custom = $_POST['custom'];
	}
	else
	{
		$custom = 'vide';
	}
	if(isset($_POST['invoice']))
	{
		$invoice = $_POST['invoice'];
	}
	else
	{
		$invoice = 'vide';
	}
}
	$destinataire = 'didier.cyprien0243@gmail.com';
    // Pour les champs $expediteur / $copie / $destinataire, séparer par une virgule s'il y a plusieurs adresses
    $expediteur = 'info@cafejadore.fr';//$_POST['email'];
    $objet = 'payment paypal Café J\'Adore';//$_POST['subject'];
    $headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
    $headers .= 'Content-type: text/html; charset=ISO-8859-1'."\n"; // l'en-tete Content-type pour le format HTML
    $headers .= 'To: '."\n"; // Mail de reponse
    $headers .= 'From: "Café J\'Adore"<'.$expediteur.'>'."\n"; // Expediteur
	$message = '<h1>//Payment Information</h1>';
	$message .= '<p>$payment_type = '.$payment_type.'</p>';
	$message .= '<p>$payment_date = '.$payment_date.'</p>';
	$message .= '<p>$payment_status = '.$payment_status.'</p>';
	$message .= '<h1>//Buyer Information</h1>';
	$message .= '<p>$address_status = '.$address_status.'</p>';
	$message .= '<p>$payer_status = '.$payer_status.'</p>';
	$message .= '<p>$first_name = '.$first_name.'</p>';// nom de famille
	$message .= '<p>$last_name = '.$last_name.'</p>';// prenom
	$message .= '<p>$payer_email = '.$payer_email.'</p>';
	$message .= '<p>$payer_id = '.$payer_id.'</p>';
	$message .= '<p>$address_name = '.$address_name.'</p>';
	$message .= '<p>$address_country = '.$address_country.'</p>';
	$message .= '<p>$address_country_code = '.$address_country_code.'</p>';
	$message .= '<p>$address_zip = '.$address_zip.'</p>';
	$message .= '<p>$address_state = '.$address_state.'</p>';
	$message .= '<p>$address_city = '.$address_city.'</p>';
	$message .= '<p>$address_street = '.$address_street.'</p>';
	$message .= '<h1>//Basic Information</h1>';
	$message .= '<p>$business = '.$business.'</p>';
	$message .= '<p>$receiver_email = '.$receiver_email.'</p>';
	$message .= '<p>$receiver_id = '.$receiver_id.'</p>';
	$message .= '<p>$residence_country = '.$residence_country.'</p>';
	$message .= '<p>$item_name1 = '.$item_name1.'</p>';

	// toute les liste sont de la meme longueur 1 article 1 numero 1 quantiter
	if(count($list_item_name) > 0) {

        $x = 0;
        foreach ($list_item_name as $value) {
            $message .= '<p>$list_item_name' . $x . '= ' . $value . '</p>';
            $x++;
        }
    }
    $message .= '<p>$item_number1 = '.$item_number1.'</p>';

	if(count($list_item_number) > 0) {
        $x = 0;
        foreach ($list_item_number as $value) {
            $message .= '<p>$list_item_number' . $x . '= ' . $value . '</p>';
            $x++;
        }
    }
	$message .= '<p>$quantity = '.$quantity.'</p>';

	if(count($list_item_quantity) > 0) {
        $x = 0;
        foreach ($list_item_quantity as $value) {
            $message .= '<p>$list_item_quantity' . $x . '= ' . $value . '</p>';
            $x++;
        }
    }
	$message .= '<p>$tax = '.$tax.'</p>';
	$message .= '<h1>//Currency and Currrency Exchange</h1>';
	$message .= '<p>$mc_currency = '.$mc_currency.'</p>';
	$message .= '<p>$mc_fee = '.$mc_fee.'</p>';
	$message .= '<p>$mc_gross_1 = '.$mc_gross_1.'</p>';
	$message .= '<p>$mc_handling = '.$mc_handling.'</p>';
	$message .= '<p>$mc_handling1 = '.$mc_handling1.'</p>';
	$message .= '<p>$mc_shipping = '.$mc_shipping.'</p>';
	$message .= '<p>$mc_shipping1 = '.$mc_shipping1.'</p>';
	$message .= '<h1>//Transaction Fields</h1>';
	$message .= '<p>$txn_type = '.$txn_type.'</p>';	
    $message .= '<p>$txn_id = '.$txn_id.'</p>';
	$message .= '<p>$notify_version = '.$notify_version.'</p>';
	$message .= '<p>$receipt_ID = '.$receipt_ID.'</p>';
	$message .= '<p>//Advanced and Custom Information</p>';
	$message .= '<p>$custom = '.$custom.'</p>';
	$message .= '<p>$invoice = '.$invoice.'</p>';

	mail($destinataire, $objet, $message, $headers);
?>