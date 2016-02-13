<?php

require_once(APPPATH.'libraries/PayPal-PHP-SDK/autoload.php');

class Paypal_test extends CI_Controller {

	public function __construct()
    {
            parent::__construct();
    }

	public function pay()
	{
		$apiContext = new ApiContext(new OAuthTokenCredential(
				"<CLIENT_ID>", "<CLIENT_SECRET>"));
		
		$addr = new Address();
		$addr->setLine1('52 N Main ST');
		$addr->setCity('Johnstown');
		$addr->setCountry_code('US');
		$addr->setPostal_code('43210');
		$addr->setState('OH');
		
		$card = new CreditCard();
		$card->setNumber('4417119669820331');
		$card->setType('visa');
		$card->setExpire_month('11');
		$card->setExpire_year('2018');
		$card->setCvv2('874');
		$card->setFirst_name('Joe');
		$card->setLast_name('Shopper');
		$card->setBilling_address($addr);
		
		$fi = new FundingInstrument();
		$fi->setCredit_card($card);
		
		$payer = new Payer();
		$payer->setPayment_method('credit_card');
		$payer->setFunding_instruments(array($fi));
		
		$amountDetails = new AmountDetails();
		$amountDetails->setSubtotal('7.41');
		$amountDetails->setTax('0.03');
		$amountDetails->setShipping('0.03');
		
		$amount = new Amount();
		$amount->setCurrency('USD');
		$amount->setTotal('7.47');
		$amount->setDetails($amountDetails);
		
		$transaction = new Transaction();
		$transaction->setAmount($amount);
		$transaction->setDescription('This is the payment transaction description.');
		
		$payment = new Payment();
		$payment->setIntent('sale');
		$payment->setPayer($payer);
		$payment->setTransactions(array($transaction));
		
		$payment->create($apiContext);
	}
}
