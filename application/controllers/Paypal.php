<?php

require_once(APPPATH.'libraries/PayPal-PHP-SDK/autoload.php');

use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\PayerInfo;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class Paypal extends CI_Controller {

	public $apiContext = null;
	public $debugMode = false;
	
	public function __construct()
    {
            parent::__construct();
            
            $this->load->library('time');
            $this->load->library('mailer');
            $this->load->model('payment_model');
            $this->load->model('achievements_and_rewards_model');
            $this->load->model('user_achievements_rewards_model');
            $this->load->model('seedon_model');
            $this->load->model('userinfo_model');
            $this->load->model('paypal_history_model');
            
            $this->apiContext = new ApiContext(new OAuthTokenCredential(
            		"Aco4HKB4be5i3gjvxBUbFdDZGw2yUqgjYndc06Psai6-_k7QjzVvC3A_QF4sLg9_yzQs06eXIfJNt3KM",
            		"EOGDj9SmynpxTkMOzjyUevgO8dnxtw9-CaqEvBIjfddWDxPJk8_fj9EumEqrsH0um2plZBKBXbqPaWND"));
            
    }
    
	public function pay()
	{
		// BEGINNING OF PAYMENT CHECK
		if(empty($_COOKIE)) return;
		if(!isset($_COOKIE['cart'])) return;

		$userID = $_COOKIE['username'];
		if(!$userID) return;
		
		if($this->debugMode) print("UTENTE: " . $userID);
		 
		$cart = json_decode($_COOKIE['cart'], true);
		if($this->debugMode) {print("<br/>WHOLE CART:"); print_r($cart);}
		
		$cartItems = $cart['items'];
		$cartOptions = $cart['options'];
		 
		if($this->debugMode) {print("<br/>ITEMS:"); print_r($cartItems);}
		if($this->debugMode) {print("<br/>OPTIONS:"); print_r($cartOptions);}
		 
		// Prendi i corsi a cui è già iscritto l'utente
		$userCourses = array();
		foreach($this->payment_model->get_courses($userID) as $course)
		{
			$userCourses[$course['courseID']] = $course;
		}
		if($this->debugMode) {print("<br/>USER'S COURSES"); print_r($userCourses);}
		 
		// Prendi tutti i corsi disponibili
		$allCourses = [];
		foreach($this->courses_model->get_all() as $course)
		{
			$allCourses[$course['courseID']] = $course;
		}
		 
		$totalItems = array();
		$total = 0;
		foreach($cartItems as $item)
		{
			$courseID = $item['courseID'];
			$courseInfo = $allCourses[$courseID];
			
			$alreadySubscribed = array_key_exists($courseID, $userCourses);
			
			// Evita di far pagare corsi che l'utente ha già acquistato
			$wantCourse = !$alreadySubscribed && $item['payCourse'] == "1";
			
			// Check se l'utente ha acquistato la simulazione
			$wantSimulation = $item['paySimulation'] == "1";
			if(!$alreadySubscribed && !$wantCourse && $wantSimulation)
			{
				if($this->debugMode) print("ERRORE: non puoi comprare solo la simulazione.");
				return;
			}
			
			// Non dare per buone le somme che arrivano dai cookie. Ricalcola.
			if($wantCourse)
			{
				$coursePrice = $courseInfo['price'];
				if($this->debugMode) print("<br/>Costo di " . $courseID . ": " . $coursePrice);
				
				$totalItems[] = array(
						'item' => $courseID,
						'price' => $coursePrice,
						'description' => "Il corso di " . $courseInfo['name'] . " a reSeed"
				);
				$total += $coursePrice;
			}
			 
			// Se l'utente ha pagato anche la simulazione, vediamo qual è il suo prezzo
			if($wantSimulation)
			{
				$simulationPrice = $courseInfo['simulationPrice'];
				if($this->debugMode) print("<br/>Costo della simulazione di " . $courseID . ": " . $simulationPrice);
				 
				if($simulationPrice)
				{
					$totalItems[] = array(
							'item' => $courseID . "-simulation",
							'price' => $simulationPrice,
							'description' => "La simulazione del corso di " . $courseInfo['name'] . " a reSeed"
					);
					$total += $simulationPrice;
				}
			}
		}
		 
		if($this->debugMode) print("<br/>PREZZO FINALE (PRE-SCONTI): " . $total);
		
		$seedOnDiscount = 0;
		// Prendi l'eventuale seedon che l'utente ha specificato e controlla che
		// i) ce l'abbia davvero
		// ii) sia ancora valido (non usato && non scaduto)
		if(array_key_exists('seedOnChosen', $cartOptions) && $cartOptions['seedOnChosen'] !== "-1")
		{
			// Prendi il seedon scelto
			$seedonChosen = $cartOptions['seedOnChosen'];
			
			if($this->debugMode) print_r("<br/>L'utente ".$userID." ha scelto il seedon con ID=" . $cartOptions['seedOnChosen']);
			 
			// Prendi tutti i seedon dell'utente
			$userSeedons = [];
			foreach($this->seedon_model->get_seedon_not_used($userID) as $seedon)
			{
				// Considera solo seedon che non sono scaduti
				if($seedon['endingDate'] > $this->time->get_timestamp())
				{
					$userSeedons[$seedon['seedonID']] = $seedon;
				}
			}
			if($this->debugMode) {print("<br/>Seedon dell'utente: "); print_r($userSeedons);}
			if($this->debugMode) print_r(array_key_exists($seedonChosen, $userSeedons));
			 
			if(array_key_exists($seedonChosen, $userSeedons))
			{
				$seedonInfo = $userSeedons[$seedonChosen];
				if($seedonInfo['tag'] === "DISCOUNT")
				{
					$seedOnDiscount = $seedonInfo['data'];
				}
			}
		}
		if($this->debugMode) print("<br/>SCONTO SEEDON FINALE: " . $seedOnDiscount);
		 
		// Considera gli sconti lifetime dell'utente
		$lifetimeDiscount = 0;
		foreach($this->user_achievements_rewards_model->get_achievements_and_rewards_obtained($userID, "REWARD", "DISCOUNT") as $discount)
		{
			$lifetimeDiscount += $discount['data'];
		}
		if($this->debugMode) print("<br/>SCONTO LIFETIME FINALE: " . $lifetimeDiscount);
		
		$totalDiscount = $seedOnDiscount + $lifetimeDiscount;
		$total = $total - ($total * $totalDiscount);
		 
		foreach($totalItems as $key => $item)
		{
// 			print("<br/>Il prezzo prima: " . $item['price']);
			$item['price'] = $item['price'] - ($item['price'] * $totalDiscount);
			$totalItems[$key] = $item;
// 			print("<br/>Il prezzo dopo: " . $item['price']);
		}
		
		// Considera se l'utente ha scelto le rate mensili
		if(array_key_exists('paymentCycleChosen', $cartOptions))
		{
			$paymentCycleChosen = $cartOptions['paymentCycleChosen'];
			if($paymentCycleChosen === "monthly")
			{
				if($this->debugMode) print("<br/>PAGANDO A RATE IL TOTALE " . $total . " DIVENTA " . ($total/3));
				$total /= 3;
				
				foreach($totalItems as $key => $item)
				{
					$item['price'] /= 3;
					$totalItems[$key] = $item;
				}
			}
		}
		 
		if($this->debugMode) print("<br/>PREZZO FINALE: " . $total);
		
		// END OF PAYMENT CHECK
		
		
// 		$apiContext->setConfig(
// 				array(
// 						'mode' => 'live',
// 				)
// 		);
		
		$userInfo = $this->userinfo_model->get($userID);
		
		$payer = new Payer();
		$payerInfo = new PayerInfo();
		
		if(array_key_exists('name', $userInfo)) $payerInfo->setFirstName($userInfo['name']);
		if(array_key_exists('surname', $userInfo))$payerInfo->setLastName($userInfo['surname']);
		if(array_key_exists('birthdate', $userInfo)) $payerInfo->setBirthDate($userInfo['birthdate']);
		
		$payerInfo->setPayerId($userID);
		
		$payer->setPayerInfo($payerInfo);
		$payer->setPaymentMethod('paypal');
		
		$amount = new Amount();
		$amount->setCurrency('EUR');
		$amount->setTotal($total);
		
		$transaction = new Transaction();
		$transaction->setAmount($amount);
		
		$itemList = new ItemList();
		
		foreach($totalItems as $cartItem)
		{
			$item = new Item();
			$item->setName($cartItem['item']);
			$item->setDescription($cartItem['description']);
			$item->setQuantity(1);
			$item->setCurrency("EUR");
			$item->setPrice($cartItem['price']);
			
			$itemList->addItem($item);
		}
		
		$transaction->setItemList($itemList);
		
		$payment = new Payment();
		$payment->setIntent('sale');
		$payment->setPayer($payer);
		$payment->setTransactions(array($transaction));
		
		// Set redirects URLs
		$redirectUrls = new RedirectUrls();
		$baseUrl = "https://www.reseed.it/index.php/";
		$redirectUrls->setReturnUrl($baseUrl . "Paypal/payment_successful")
		->setCancelUrl($baseUrl . "Paypal/payment_cancelled");
		$payment->setRedirectUrls($redirectUrls);
		
		try {
			
			$response = $payment->create($this->apiContext);
			
			// Salva sul DB il successo
			$this->paypal_history_model->add($response->getId(), $userID, json_encode($payment->toJSON()), json_encode($response->toJSON()), $this->time->get_timestamp(), $response->getState());
		}
		catch (\PayPal\Exception\PayPalConnectionException $ex) {
			echo json_encode(array("error" => true, "description" => "Errore durante la connessione a Paypal. Riprova più tardi. Dettagli errore: " . $ex->getData(), "errorCode" => "PAYPAL_ERROR", "parameters" => array("")));
			return;
		}
		
		echo json_encode(array("error" => false, "url" => $response->getApprovalLink()));
		return;
	}
	
	public function payment_successful()
	{
		$userID = $_COOKIE['username'];
		if(!$userID) return;
		
		$paymentId = $_GET['paymentId'];
		$payerID = $_GET['PayerID'];
		
		$payment = Payment::get($paymentId, $this->apiContext);
		
		$paymentExecution = new PaymentExecution();
		$paymentExecution->setPayerId($payerID);
		
		try {
			$response = $payment->execute($paymentExecution, $this->apiContext);

			// Salva nel DB la risposta da paypal
			$this->paypal_history_model->add($response->getId(), $userID, json_encode($payment->toJSON()), json_encode($response->toJSON()), $this->time->get_timestamp(), $response->getState());
			
			if($response->getState() === "approved")
			{
				// Aggiungi i corsi alla tabella "Payment"
				$cart = json_decode($_COOKIE['cart'], true);
				$cartItems = $cart['items'];
				$cartOptions = $cart['options'];
				
				foreach($cartItems as $item)
				{
					$courseID = $item['courseID'];
						
					// Evita di far pagare corsi che l'utente ha già acquistato
					$wantCourse = $item['payCourse'] == "1";
					
					// Check se l'utente ha acquistato la simulazione
					$wantSimulation = $item['paySimulation'] == "1";
					
					$simulation = $wantSimulation;
					$paymentChoice = $cartOptions['paymentMediaChosen'];
					$rate = $cartOptions['paymentCycleChosen'];
					$paymentDate = $this->time->get_timestamp();
					
					if($wantCourse)
					{
						// Aggiungi il corso alla tabella
						$this->payment_model->add($userID, $courseID, $simulation, $paymentChoice, $rate, $paymentDate, $response->getId(), $response->getId());
					}
					else if($wantSimulation)
					{
						// Aggiungi la simulazione alla tabella
						$this->payment_model->add_simulation($userID, $courseID, $response->getId());						
					}
				}
				
				// Remove the seedon from the user
				$this->seedon_model->use_seedon($cartOptions['seedOnChosen']);
				
				// Svuota il carrello
				unset($_COOKIE['cart']);
				setcookie('cart', '', time() - 3600, '/');
				
				// Redirect to payment OK
				header("location: /paymentOK");
			}
		}
		catch (\PayPal\Exception\PayPalConnectionException $ex) {
			// Salva nel DB l'errore
			$this->paypal_history_model->add($payment->getId(), $userID, json_encode($payment->toJSON()), $ex->getData(), $this->time->get_timestamp(), $payment->getState());
			
			header("location: /paymentFailed/" . $payment->getState());
			return;
		}
	}
	
	public function payment_cancelled()
	{
// 		print("Hai deciso di cancellare il pagamento.");
// 		$token = $_GET['token'];
// 		print("PAYMENT TOKEN: " . $token);
		
		// Redirect to payment failed
		header("location: /paymentCancelled");
	}
}
