<?php

/**
 * Class for processing recurring payments via ARB API Authorize.net 
 * Original code by John Conde: http://www.merchant-account-services.org/blog/
 * with a few changes by Alexis Bellido: http://www.ventanazul.com/webzine/articles/authorize-recurring-billing-php-class
 */

class AuthnetARB {
  var $login;
  var $transkey;
  var $test;

  var $params   = array();
  var $success   = false;
  var $error    = true;

  var $url;
  var $xml;
  var $response;
  var $resultCode;
  var $code;
  var $text;
  var $subscrId;

  function AuthnetARB($login, $transkey, $test) {
    $this->login = $login;
    $this->transkey = $transkey;
    $this->test = $test;

    $subdomain = ($this->test) ? 'apitest' : 'api';	
	
    $this->url = "https://api.authorize.net/xml/v1/request.api";
  }

  function getString() {
    if (!$this->params) {
      return (string) $this;
    }

    $output  = "";
    $output .= '<table summary="Authnet Results" id="authnet">' . "\n";
    $output .= '<tr>' . "\n\t\t" . '<th colspan="2"><b>Outgoing Parameters</b></th>' . "\n" . '</tr>' . "\n";

    foreach ($this->params as $key => $value) {
      $output .= "\t" . '<tr>' . "\n\t\t" . '<td><b>' . $key . '</b></td>';
      $output .= '<td>' . $value . '</td>' . "\n" . '</tr>' . "\n";
    }

    $output .= '</table>' . "\n";
    return $output;
  }

  function process($retries = 3) {
    $count = 0;
	
	
    while ($count < $retries)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->xml);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $this->response = curl_exec($ch);
        $this->parseResults();
        
        if ($this->resultCode === "Ok") {
          $this->success = true;
          $this->error   = false;
          break;
        } else {
          $this->success = false;
          $this->error   = true;
          break;
        }
        $count++;
    }
	curl_close($ch);
//        echo "<pre>";
//		echo $this->xml;
//        echo $this->response;
//        echo $this->resultCode;
//        echo "</pre>";
//        die(); 
    
  }

  function createAccount() {
	    $this->xml = "<?xml version='1.0' encoding='utf-8'?>
                  <ARBCreateSubscriptionRequest xmlns='AnetApi/xml/v1/schema/AnetApiSchema.xsd'>
                      <merchantAuthentication>
                          <name>" . $this->login . "</name>
                          <transactionKey>" . $this->transkey . "</transactionKey>
                      </merchantAuthentication>
                      <refId>" . $this->params['refID'] ."</refId>
                      <subscription>
                          <name>". $this->params['subscrName'] ."</name>
                          <paymentSchedule>
                              <interval>
                                  <length>". $this->params['interval_length'] ."</length>
                                  <unit>". $this->params['interval_unit'] ."</unit>
                              </interval>
                              <startDate>" . $this->params['startDate'] . "</startDate>
                              <totalOccurrences>". $this->params['totalOccurrences'] . "</totalOccurrences>
                              <trialOccurrences>". $this->params['trialOccurrences'] . "</trialOccurrences>
                          </paymentSchedule>
                          <amount>". $this->params['amount'] ."</amount>
                          <trialAmount>" . $this->params['trialAmount'] . "</trialAmount>
                          <payment>
                              <creditCard>
                                  <cardNumber>" . $this->params['cardNumber'] . "</cardNumber>
                                  <expirationDate>" . $this->params['expirationDate'] . "</expirationDate>
                              </creditCard>
                          </payment>
                          <customer>
								<email>" . $this->params['email'] . "</email>
								<phoneNumber>" . $this->params['phone'] . "</phoneNumber>
						  </customer>
                          <billTo>
                              <firstName>". $this->params['firstName'] . "</firstName>
                              <lastName>" . $this->params['lastName'] . "</lastName>
                              <address>" . $this->params['address'] . "</address>
                              <city>" . $this->params['city'] . "</city>
                              <state>" . $this->params['state'] . "</state>
                              <zip>" . $this->params['zip'] . "</zip>
                              <country>" . $this->params['country'] . "</country>
                          </billTo>
                      </subscription>
                  </ARBCreateSubscriptionRequest>";
	
	
    $this->process();
  }

  function updateAccount() {
    $this->xml = "<?xml version='1.0' encoding='utf-8'?>
                  <ARBUpdateSubscriptionRequest xmlns='AnetApi/xml/v1/schema/AnetApiSchema.xsd'>
                      <merchantAuthentication>
                          <name>" . $this->login . "</name>
                          <transactionKey>" . $this->transkey . "</transactionKey>
                      </merchantAuthentication>
                      <refId>" . $this->params['refID'] ."</refId>
                      <subscriptionId>" . $this->params['subscrId'] . "</subscriptionId>
                      <subscription>
                          <payment>
                              <creditCard>
                                  <cardNumber>" . $this->params['cardNumber'] . "</cardNumber>
                                  <expirationDate>" . $this->params['expirationDate'] . "</expirationDate>
                              </creditCard>
                          </payment>
                      </subscription>
                  </ARBUpdateSubscriptionRequest>";
    $this->process();
  }

  function deleteAccount() {
    $this->xml = "<?xml version='1.0' encoding='utf-8'?>
                  <ARBCancelSubscriptionRequest xmlns='AnetApi/xml/v1/schema/AnetApiSchema.xsd'>
                      <merchantAuthentication>
                          <name>" . $this->login . "</name>
                          <transactionKey>" . $this->transkey . "</transactionKey>
                      </merchantAuthentication>
                      <refId>" . $this->params['refID'] ."</refId>
                      <subscriptionId>" . $this->params['subscrId'] . "</subscriptionId>
                  </ARBCancelSubscriptionRequest>";
    $this->process();
  }

  function parseResults() {
    $this->resultCode = $this->substring_between($this->response,'<resultCode>','</resultCode>');
    $this->code = $this->substring_between($this->response,'<code>','</code>');
    $this->text = $this->substring_between($this->response,'<text>','</text>');
    $this->subscrId = $this->substring_between($this->response,'<subscriptionId>','</subscriptionId>');
  }

  function substring_between($haystack,$start,$end) {
     if (strpos($haystack,$start) === false || strpos($haystack,$end) === false) {
        return false;
     } else {
        $start_position = strpos($haystack,$start)+strlen($start);
        $end_position = strpos($haystack,$end);
        return substr($haystack,$start_position,$end_position-$start_position);
     }
  }

  function setParameter($field = "", $value = null) {
    $field = (is_string($field)) ? trim($field) : $field;
    $value = (is_string($value)) ? trim($value) : $value;

    if (!is_string($field)) {
      die("setParameter() arg 1 must be a string or integer: " . gettype($field) . " given.");
    }

    if (!is_string($value) && !is_numeric($value) && !is_bool($value)) {
      die("setParameter() arg 2 must be a string, integer, or boolean value: " . gettype($value) . " given.");
    }

    if (empty($field)) {
      die("setParameter() requires a parameter field to be named.");
    }

    if ($value === "") {
      die("setParameter() requires a parameter value to be assigned: $field");
    }

    $this->params[$field] = $value;
  }

  function isSuccessful() {
    return $this->success;
  }

  function isError() {
    return $this->error;
  }

  function getResponse() {
    return $this->text;
  }

  function getRawResponse() {
    return $this->response;
  }

  function getResultCode() {
    return $this->resultCode;
  }

  function getSubscriberID() {
    return $this->subscrId;
  }
}


function create_arb_authorize_dot_net($user_info) {
	$login = '8hZ68Mf36';
	$transkey = '7aX982a8e7Fy4A7x';
	$test = false;
	
	$arb = new AuthnetARB($login, $transkey, $test);
	
	$arb->setParameter('interval_length', $user_info["interval"]);
	$arb->setParameter('interval_unit', $user_info["unit"]);
	$arb->setParameter('startDate', date("Y-m-d"));
	$arb->setParameter('totalOccurrences', $user_info["occurrences"]);
	$arb->setParameter('trialOccurrences', 0);
	$arb->setParameter('trialAmount', 0.00);
	
	$arb->setParameter('amount', $user_info['amount']);
	/*$arb->setParameter('refId', 15);*/
	$arb->setParameter('cardNumber', $user_info['card_num']);
	
//	$arb->setParameter('cardNumber', '370000000000002');    //test amex card
//	$arb->setParameter('cardNumber', '6011000000000012');	//test discover card
//	$arb->setParameter('cardNumber', '5424000000000015');	//test mastercard
//	$arb->setParameter('cardNumber', '4222222222222');   	//test fail
	
	$arb->setParameter('expirationDate', $user_info['exp_date']);

	$arb->setParameter('firstName', $user_info['first_name']);
	$arb->setParameter('lastName', $user_info['last_name']);
	$arb->setParameter('address', $user_info['address']);
	$arb->setParameter('city', $user_info['city']);
	$arb->setParameter('state', $user_info['state']);
	$arb->setParameter('zip', $user_info['zip']);
	$arb->setParameter('country', $user_info['country']);
	
	$arb->setParameter('email', $user_info['email']);
	$arb->setParameter('phone', $user_info['phone']);
	
	//$arb->setParameter('subscrName', 'Hunters and Guides Connection Membership Subscription');
	$arb->createAccount();
	
	//echo 'isSuccessful: ' .$arb->isSuccessful() . '<br />';
	
	$_SESSION["authorize_status"] = $arb->isSuccessful();
	$_SESSION['authorize_message'] = $arb->getResponse();
	$_SESSION["authorize_error"] = $arb->isError();
	$_SESSION["authorize_subscriptionId"] = $arb->getSubscriberID();
	
	if ($arb->isSuccessful()) {
		return true;
	} else {
		return false;
	}
	
//	echo 'isError: ' .$arb->isError() . '<br />';
//	echo 'getSubscriberID: ' .$arb->getSubscriberID() . '<br />';
//	echo 'getResponse: ' .$arb->getResponse() . '<br />';
//	echo 'getResultCode:' .$arb->getResultCode() . '<br />';
//	echo 'getString: ' .$arb->getString() . '<br />';
//	echo 'getRawResponse: ' .$arb->getRawResponse() . '<br />';
}
?>
