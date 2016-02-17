<?php

require_once(APPPATH.'libraries/PayPal-PHP-SDK/autoload.php');

use PayPal\Api\Address;
use PayPal\Api\Amount;
use PayPal\Api\Cost;
use PayPal\Api\CreditCard;
use PayPal\Api\Currency;
use PayPal\Api\Details;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Invoice;
use PayPal\Api\InvoiceItem;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class Paypal_test extends CI_Controller {

	public $apiContext = null;
	
	public function __construct()
    {
            parent::__construct();
            
            $this->apiContext = new ApiContext(new OAuthTokenCredential(
            		"Aco4HKB4be5i3gjvxBUbFdDZGw2yUqgjYndc06Psai6-_k7QjzVvC3A_QF4sLg9_yzQs06eXIfJNt3KM",
            		"EOGDj9SmynpxTkMOzjyUevgO8dnxtw9-CaqEvBIjfddWDxPJk8_fj9EumEqrsH0um2plZBKBXbqPaWND"));
            
    }

	public function pay()
	{
		
// 		$apiContext->setConfig(
// 				array(
// 						'mode' => 'live',
// 				)
// 		);
		
		$payer = new Payer();
		$payer->setPaymentMethod('paypal');
		
		$amount = new Amount();
		$amount->setCurrency('EUR');
		$amount->setTotal('0.06');
		
		$transaction = new Transaction();
		$transaction->setAmount($amount);
		
		$itemList = new ItemList();
		$item = new Item();
		$item->setName("3DStudioMax");
		$item->setDescription("Il corso di grafica 3D a reSeed");
		$item->setQuantity(1);
		$item->setCurrency("EUR");
		$item->setPrice('0.05');
		$itemList->addItem($item);
		
		$item = new Item();
		$item->setName("Simulazione 3DStudioMax");
		$item->setDescription("La simulazione del corso di grafica 3D a reSeed");
		$item->setQuantity(1);
		$item->setCurrency("EUR");
		$item->setPrice('0.01');
		$itemList->addItem($item);
		
		$transaction->setItemList($itemList);
		
		$payment = new Payment();
		$payment->setIntent('sale');
		$payment->setPayer($payer);
		$payment->setTransactions(array($transaction));
		
		// Set redirects URLs
		$redirectUrls = new RedirectUrls();
		$baseUrl = "https://www.reseed.it/index.php/";
		$redirectUrls->setReturnUrl($baseUrl . "Paypal_test/payment_successful")
		->setCancelUrl($baseUrl . "Paypal_test/payment_cancelled");
		$payment->setRedirectUrls($redirectUrls);
		
		// Invoice information
// 		$invoice = new Invoice();
// 		$items = array();
// 		$items[0] = new InvoiceItem();
// 		$items[0]->setName("3DStudioMax")->setQuantity(1)->setUnitPrice(new Currency());		
// 		$items[0]->getUnitPrice()->setCurrency("EUR")->setValue(0.05);
		
// 		$cost = new Cost();
// 		$cost->setPercent("10");
// 		$invoice->setDiscount($cost);
		
// 		$invoice->setLogoUrl("https://www.reseed.it/imgs/logo.png");
		
// 		$invoice->setItems($items);
		
// 		try {
// 			$response = $invoice->create($apiContext);
// 			print("INVOICE SUCCESS!");
// 			print_r($response);
// 		} catch (Exception $ex) {
// 			print("INVOICE FAILURE");
// 			print_r($response);
// 			return;
// 		}
		
		try {
			$payment = $payment->create($this->apiContext);
			echo "SUCCESS:";
			echo $payment;
		}
		catch (\PayPal\Exception\PayPalConnectionException $ex) {
			echo "ERROR:";
			echo $ex->getData();
			return;
		}
		
		$approvalUrl = $payment->getApprovalLink();
		
		print("APPROVAL URL:" . $approvalUrl);
		print("<a target=\"_blank\" href=\"".$approvalUrl."\">Clicca qui per accettare il pagamento</a>");
	}
	
	public function payment_successful()
	{
		$paymentId = $_GET['paymentId'];
		$payerID = $_GET['PayerID'];
		
		print("PAYMENT ID: " . $paymentId);
		print("PAYER ID: " . $payerID);
		
		$payment = Payment::get($paymentId, $this->apiContext);
		
		$paymentExecution = new PaymentExecution();
		$paymentExecution->setPayerId($payerID);
		
		try {
			$payment->execute($paymentExecution, $this->apiContext);
			echo "CONFIRMATION SUCCESS:";
			echo $payment;
		}
		catch (\PayPal\Exception\PayPalConnectionException $ex) {
			echo "CONFIRMATION ERROR:";
			echo $ex->getData();
		}
	}
	
	public function payment_cancelled()
	{
		print("ERROR IN PROCESSING YOUR PAYMENT REQUEST");
		
		$paymentId = $_GET['paymentId'];
		$payerID = $_GET['PayerID'];
		
		print("PAYMENT ID: " . $paymentId);
		print("PAYER ID: " . $payerID);
	}
}
