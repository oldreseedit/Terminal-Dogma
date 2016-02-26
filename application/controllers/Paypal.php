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

	public $debugMode = false;
	const defaultTeacher = "Titto";
	
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
            $this->load->model('preferences_model');
            $this->load->model('paypal_history_model');
            $this->load->model('course_teachers_model');
            $this->load->model('teachers_model');
    }
    
    private function get_credentials($teacherID)
    {
    	if($teacherID == null) $teacherID = "default";
    	
		$go_live = false;
		
		$file_content = file_get_contents(APPPATH . '/../../paypal_credentials.json');
    	$all_credentials = json_decode($file_content, true);
    	$teacher_credentials = $all_credentials[$teacherID];
    	$credentials = $teacher_credentials[$go_live ? 'live' : 'sandbox'];
    	
    	$apiContext = new ApiContext(new OAuthTokenCredential($credentials['clientID'], $credentials['clientSecret']));
//     	print_r($apiContext);
    	
    	// To make the service live!
    	if($go_live) $apiContext->setConfig(array('mode' => 'live'));
    	
    	return $apiContext;
    }
    
    private function get_total($userID, $cartItems, $cartOptions)
    {
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
    	
//     	print("<br/>CART:");
//     	print_r($cartItems);
    	
//     	$totalItems = array();
    	$total = 0;
    	foreach($cartItems as $item)
    	{
    		$courseID = $item['courseID'];
    		$courseInfo = $allCourses[$courseID];
    			
    		// Evita di far pagare corsi che l'utente ha già acquistato
    		$wantCourse = $item['payCourse'] == "1";
    			
    		// Check se l'utente ha acquistato la simulazione
    		$wantSimulation = $item['paySimulation'] == "1";
    			
    		// Non dare per buone le somme che arrivano dai cookie. Ricalcola.
    		if($wantCourse)
    		{
    			$coursePrice = $courseInfo['price'];
    			if($this->debugMode) print("<br/>Costo di " . $courseID . ": " . $coursePrice);
    	
    			$total += $coursePrice;
    		}
    	
    		// Se l'utente ha pagato anche la simulazione, vediamo qual è il suo prezzo
    		if($wantSimulation)
    		{
    			$simulationPrice = $courseInfo['simulationPrice'];
    			if($this->debugMode) print("<br/>Costo della simulazione di " . $courseID . ": " . $simulationPrice);
    				
    			if($simulationPrice)
    			{
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
    		
//     	foreach($totalItems as $key => $item)
//     	{
//     		// 			print("<br/>Il prezzo prima: " . $item['price']);
//     		$item['price'] = $item['price'] - ($item['price'] * $totalDiscount);
//     		$totalItems[$key] = $item;
//     		// 			print("<br/>Il prezzo dopo: " . $item['price']);
//     	}
    	
    	// Considera se l'utente ha scelto le rate mensili
    	if(array_key_exists('paymentCycleChosen', $cartOptions))
    	{
    		$paymentCycleChosen = $cartOptions['paymentCycleChosen'];
    		if($paymentCycleChosen === "monthly")
    		{
    			if($this->debugMode) print("<br/>PAGANDO A RATE IL TOTALE " . $total . " DIVENTA " . ($total/3));
    			$total /= 3;
    	
//     			foreach($totalItems as $key => $item)
//     			{
//     				$item['price'] /= 3;
//     				$totalItems[$key] = $item;
//     			}
    		}
    	}
    	
    	return $total;
    }
    
	public function pay()
	{
		// BEGINNING OF PAYMENT CHECK
		if(empty($_COOKIE))
		{
			echo json_encode(array("error" => true, "description" => "Non hai effettuato l'accesso a reSeed. Effettua l'accesso e riprova.", "errorCode" => "ACCESS_DENIED", "parameters" => array()));
			return;
		}
		if(!isset($_COOKIE['cart']))
		{
			echo json_encode(array("error" => true, "description" => "Non hai inserito alcun articolo nel carrello.", "errorCode" => "EMPTY_CART_ERROR", "parameters" => array()));
			return;
		}

		$userID = $_COOKIE['username'];
		if(!$userID)
		{
			echo json_encode(array("error" => true, "description" => "Non hai effettuato l'accesso a reSeed. Effettua l'accesso e riprova.", "errorCode" => "ACCESS_DENIED", "parameters" => array()));
			return;
		}
		
		$cart = json_decode($_COOKIE['cart'], true);
		$cartItems = $cart['items'];
		$cartOptions = $cart['options'];
		
		if(!array_key_exists('paymentMediaChosen', $cartOptions))
		{
			echo json_encode(array("error" => true, "description" => "Non hai selezionato un mezzo di pagamento.", "errorCode" => "MISSING_PAYMENT_MEDIA", "parameters" => array()));
			return;
		}
		
		if($this->debugMode) print("UTENTE: " . $userID);
		if($this->debugMode) {print("<br/>WHOLE CART:"); print_r($cart);}
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
				
				echo json_encode(array("error" => true, "description" => "Non è possibile acquistare soltanto la simulazione per un corso. Seleziona anche il corso e riprova.", "errorCode" => "INVALID_CHOICE", "parameters" => array("paySimulation")));
				return;
			}
			
			// Non dare per buone le somme che arrivano dai cookie. Ricalcola.
			if($wantCourse)
			{
				$coursePrice = $courseInfo['price'];
				if($this->debugMode) print("<br/>Costo di " . $courseID . ": " . $coursePrice);
				
				$totalItems[] = array(
						'item' => $courseID,
						'itemType' => 'course',
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
							'itemType' => 'simulation',
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
		
		$paymentChoice = $cartOptions['paymentMediaChosen'];
		if($paymentChoice === "wireTransfer")
		{
			// Salva sul DB la richiesta di pagamento
			$paymentID = "WT-" . $this->randomString();
			$this->paypal_history_model->add($paymentID, $userID, $_COOKIE['cart'], "", $this->time->get_timestamp(), "created");
			
			// Aggiungiamo la pre-iscrizione al DB (se necessario)
			foreach($cartItems as $item)
			{
				$courseID = $item['courseID'];
				$payment = $this->payment_model->get_payment($userID, $courseID);
				if(empty($payment))
				{
					$this->payment_model->add($userID, $courseID);
				}
			}
			
			sleep(3);
			
			echo json_encode(array("error" => false, "url" => "index.php/Paypal/payment_successful?paymentId=".$paymentID . "&PayerID=".$userID));
			return;
		}
		else if($paymentChoice === "cash")
		{
			$paymentID = "CASH-" . $this->randomString();
			$this->paypal_history_model->add($paymentID, $userID, $_COOKIE['cart'], "", $this->time->get_timestamp(), "created");
			
			// Aggiungiamo la pre-iscrizione al DB (se necessario)
			foreach($cartItems as $item)
			{
				$courseID = $item['courseID'];
				$payment = $this->payment_model->get_payment($userID, $courseID);
				if(empty($payment))
				{
					$this->payment_model->add($userID, $courseID);
				}
			}
			
			sleep(3);
			
			echo json_encode(array("error" => false, "url" => "index.php/Paypal/payment_successful?paymentId=".$paymentID . "&PayerID=".$userID));
			return;
		}
		else if($paymentChoice === "creditCard")
		{
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
				
				// Prendiamo i docenti di tutti i corsi
				$all_teachers = array();
				foreach ($this->course_teachers_model->get_all_teachers() as $course_teacher)
				{
					$all_teachers[$course_teacher['courseID']] = $course_teacher['teacherID'];
				}
				
				// Vediamo quali sono i docenti coinvolti dal pagamento dell'utente
				$course_teachers = array();
				foreach ($cartItems as $cartItem)
				{
					if($cartItem['payCourse'] == "1" || $cartItem['paySimulation'] == "1")
					{
						$teacher = $all_teachers[$cartItem['courseID']];
						if(!array_key_exists($teacher, $course_teachers))
							$course_teachers[] = $teacher;
					}
				}
				
				$teacher = null;
				if(count($course_teachers) == 1) $teacher = $course_teachers[0];
				
				$apiContext = $this->get_credentials($teacher);
				
// 				print("USING CREDENTIALS: ");
// 				print_r($apiContext);
				
				$response = $payment->create($apiContext);
				
				// Salva sul DB il successo
				$this->paypal_history_model->add($response->getId(), $userID, json_encode($payment->toJSON()), json_encode($response->toJSON()), $this->time->get_timestamp(), $response->getState());
			}
			catch (\PayPal\Exception\PayPalConnectionException $ex) {
				echo json_encode(array("error" => true, "description" => "Errore durante la connessione a Paypal. Riprova più tardi. Dettagli errore: " . $ex->getData(), "errorCode" => "PAYPAL_ERROR", "parameters" => array("")));
				return;
			}
			
			// Aggiungiamo la pre-iscrizione al DB (se necessario)
			foreach($cartItems as $item)
			{
				$courseID = $item['courseID'];
				$payment = $this->payment_model->get_payment($userID, $courseID);
				if(empty($payment))
				{
					$this->payment_model->add($userID, $courseID);
				}
			}
			
			echo json_encode(array("error" => false, "url" => $response->getApprovalLink()));
			return;
		}
	}
	
	private function randomString($length = 32) {
		$str = "";
		$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
		$max = count($characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $characters[$rand];
		}
		return $str;
	}
	
	// created; approved; failed; canceled; expired; pending
	public function payment_successful()
	{
		$userID = $_COOKIE['username'];
		if(!$userID)
		{
			echo json_encode(array("error" => true, "description" => "Non hai effettuato l'accesso a reSeed. Effettua l'accesso e riprova.", "errorCode" => "ACCESS_DENIED", "parameters" => array()));
			return;
		}
		
		$paymentId = $_GET['paymentId'];
		$payerID = $_GET['PayerID'];
		
		$cart = json_decode($_COOKIE['cart'], true);
		$cartItems = $cart['items'];
		$cartOptions = $cart['options'];
		$paymentChoice = $cartOptions['paymentMediaChosen'];
		$paymentCycle = $cartOptions['paymentCycleChosen'];
		$total = $this->get_total($userID, $cartItems, $cartOptions);
		
		$summaryData = array();
		
		$queryString = "/" . "" . $paymentId;
		$summaryData['Codice transazione'] = $paymentId;
		
		$queryString .= "/" . "" . $total;
		$summaryData['Importo'] = $total . "€";
		
		$queryString .= "/" . "" . ($paymentCycle === "monthly" ? "A rate mensili" : "Soluzione unica");
		$summaryData['Modalità di pagamento'] = ($paymentCycle === "monthly" ? "A rate mensili" : "Soluzione unica");
		
		$state = null;
		
		if($paymentChoice === "cash")
		{
			$queryString .= "/contanti";
			$summaryData['Pagamento da effettuarsi con'] = "contanti";
			
			$state = "pending";
			$this->paypal_history_model->add($paymentId, $userID, $_COOKIE['cart'], "OK", $this->time->get_timestamp(), $state);
		}
		else if($paymentChoice === "wireTransfer")
		{
			$queryString .= "/bonifico";
			$summaryData['Pagamento da effettuarsi con'] = "bonifico";
			
			// Prendiamo i docenti di tutti i corsi
			$all_teachers = array();
			foreach ($this->course_teachers_model->get_all_teachers() as $course_teacher)
			{
				$all_teachers[$course_teacher['courseID']] = $course_teacher['teacherID'];
			}
			
			// Vediamo quali sono i docenti coinvolti dal pagamento dell'utente
			$course_teachers = array();
			foreach ($cartItems as $cartItem)
			{
				if($cartItem['payCourse'] == "1" || $cartItem['paySimulation'] == "1")
				{
					$teacher = $all_teachers[$cartItem['courseID']];
					if(!in_array($teacher, $course_teachers))
						$course_teachers[] = $teacher;
				}
			}
			
			// Determiniamo il conto corrente target
			$wireTransferCode = null;
			$wireTransferHolder = null;
			
			// Se c'è solo un docente coinvolto (e ha un conto in banca): scegliamo il suo conto corrente
			if(count($course_teachers) == 1)
			{
				$teacher = $course_teachers[0];
				$teacherInfo = $this->teachers_model->get($teacher);
				if(array_key_exists('accountNo', $teacherInfo))
				{
					$wireTransferCode = $teacherInfo['accountNo'];
					$wireTransferHolder = $teacherInfo['accountHolder'];
				}
			}
			
			// Altrimenti depositiamo tutto sul conto di reSeed
			if($wireTransferCode == null)
			{
				$defaultTeacherInfo = $this->teachers_model->get(self::defaultTeacher);
				$wireTransferCode = $defaultTeacherInfo['accountNo'];
				$wireTransferHolder = $defaultTeacherInfo['accountHolder'];
			}
			
			// Aggiungiamo la causale/ragione sociale
			$wireTransferReason = "reSeed - Acquisto di ";
			$numCourses = 0;
			$numSimulations = 0;
			foreach ($cartItems as $cartItem)
			{
				if($cartItem['payCourse'] == "1") $numCourses++;
				if($cartItem['paySimulation'] == "1") $numSimulations++;
			}
			
			if($numCourses > 0) $wireTransferReason .= $numCourses . " cors"  . ($numCourses == 1 ? "o":"i");
			if($numCourses > 0 && $numSimulations > 0) $wireTransferReason .= " e "; 
			if($numSimulations > 0) $wireTransferReason .= $numSimulations . " simulazion" . ($numSimulations == 1 ? "e":"i");
			
			$queryString .= "/" .  "" . $wireTransferCode;
			$queryString .= "/" . "" . $wireTransferReason;
			$queryString .= "/" . "" . $wireTransferHolder;
			$summaryData['IBAN'] = $wireTransferCode;
			$summaryData['Ragione sociale'] = $wireTransferReason;
			$summaryData['Intestatario'] = $wireTransferHolder;

			$state = "pending";
			$this->paypal_history_model->add($paymentId, $userID, $_COOKIE['cart'], "OK", $this->time->get_timestamp(), $state);
		}
		else if($paymentChoice === "creditCard")
		{
			$queryString .= "/paypal";
			
			// Prendiamo i docenti di tutti i corsi
			$all_teachers = array();
			foreach ($this->course_teachers_model->get_all_teachers() as $course_teacher)
			{
				$all_teachers[$course_teacher['courseID']] = $course_teacher['teacherID'];
			}
			
			// Vediamo quali sono i docenti coinvolti dal pagamento dell'utente
			$course_teachers = array();
			foreach ($cartItems as $cartItem)
			{
				if($cartItem['payCourse'] == "1" || $cartItem['paySimulation'] == "1")
				{
					$teacher = $all_teachers[$cartItem['courseID']];
					if(!array_key_exists($teacher, $course_teachers))
						$course_teachers[] = $teacher;
				}
			}
			
			$teacher = null;
			if(count($course_teachers) == 1) $teacher = $course_teachers[0];
			$apiContext = $this->get_credentials($teacher);
			
			$payment = Payment::get($paymentId, $apiContext);
			
			$paymentExecution = new PaymentExecution();
			$paymentExecution->setPayerId($payerID);
			
			try {
				$response = $payment->execute($paymentExecution, $apiContext);
	
				// Salva nel DB la risposta da paypal
				$this->paypal_history_model->add($response->getId(), $userID, json_encode($payment->toJSON()), json_encode($response->toJSON()), $this->time->get_timestamp(), $response->getState());
				
				$state = $response->getState();
				
				if($state === "approved")
				{
					$allCourses = [];
					foreach($this->courses_model->get_all() as $course)
					{
						$allCourses[$course['courseID']] = $course;
					}
					
					$userInfo = $this->userinfo_model->get($userID);
					
					// Aggiungi i corsi alla tabella "Payment"
					$cart = json_decode($_COOKIE['cart'], true);
					$cartItems = $cart['items'];
					$cartOptions = $cart['options'];

					$rights = $this->preferences_model->get($userID);
					
					foreach($cartItems as $item)
					{
						$courseID = $item['courseID'];
						$courseInfo = $allCourses[$courseID];
						
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
							$this->mailer->send_mail("info@reseed.it", $userID . " si è appena iscritto al corso di " . $courseID, "L'utente ".$userID." (nome:".$userInfo['name'].", cognome:".$userInfo['surname'].") si è appena iscritto al corso di " . $courseID . "!");
							
							// If the user agreed to receive emails, send him an email with the notification
							if($rights && $rights['info'] && array_key_exists('email', $userInfo))
								$this->mailer->send_mail($userInfo['email'], "La tua iscrizione ai corsi di reSeed", "Grazie per esserti iscritto al corso di " . $courseInfo['name'] . "!");
						}
						else if($wantSimulation)
						{
							$this->mailer->send_mail("info@reseed.it", $userID . " si è appena iscritto alla simulazione di " . $courseID, "L'utente ".$userID." (nome:".$userInfo['name'].", cognome:".$userInfo['surname'].") si è appena iscritto alla simulazione di " . $courseID . "!");
							
							// If the user agreed to receive emails, send him an email with the notification
							if($rights && $rights['info'] && array_key_exists('email', $userInfo))
								$this->mailer->send_mail($userInfo['email'], "La tua iscrizione ai corsi di reSeed", "Grazie per esserti iscritto alla simulazione di " . $courseInfo['name'] . "!");
						}
					}
				}
			}
			catch (\PayPal\Exception\PayPalConnectionException $ex) {
				$this->paypal_history_model->add($payment->getId(), $userID, json_encode($payment->toJSON()), $ex->getData(), $this->time->get_timestamp(), $payment->getState());
				
				$state = $payment->getState();
			}
		}
		
		if($state === "approved")
		{
			// Aggiungiamo la pre-iscrizione al DB (se necessario)
			foreach($cartItems as $item)
			{
				$courseID = $item['courseID'];
				$payCourse = $item['payCourse'];
				$paySimulation = $item['paySimulation'];
				
				if($payCourse) $this->payment_model->update_course($userID, array($courseID), $paymentId);
				if($paySimulation) $this->payment_model->update_simulation($userID, $courseID, $paymentId);
			}
			
			// Redirect to payment OK
			header("location: /paymentOK" . $queryString);
		}
		else if($state === "pending")
		{
			$this->send_reminder_mail($userID, $cartItems, $cartOptions, $summaryData);
			
			// Redirect to payment OK
			header("location: /paymentPending" . $queryString);
		}
		else if($state === "failed" || $state === "expired")
		{
			header("location: /paymentFailed/" . $state);
		}
		
		if($state !== "failed" && $state !== "expired")
		{
			// Aggiungiamo la pre-iscrizione al DB (se necessario)
			foreach($cartItems as $item)
			{
				$courseID = $item['courseID'];
				$payCourse = $item['payCourse'];
				$paySimulation = $item['paySimulation'];
			
				if($payCourse) $this->payment_model->update_course_payment($userID, $courseID, $paymentId);
				if($paySimulation) $this->payment_model->update_simulation_payment($userID, $courseID, $paymentId);
			}
			
			// Remove the seedon from the user
			$this->seedon_model->use_seedon($cartOptions['seedOnChosen']);
		
			// Svuota il carrello
			unset($_COOKIE['cart']);
			setcookie('cart', '', time() - 3600, '/');
		}
	}
	
	public function payment_cancelled()
	{
		// Redirect to payment failed
		header("location: /paymentCancelled");
	}
	
	private function send_reminder_mail($userID, $cartItems, $cartOptions, $data)
	{
		$userInfo = $this->userinfo_model->get($userID);
		$rights = $this->preferences_model->get($userID);
		
		$message = "<p>Grazie per aver effettuato il pagamento</p>";
		$message .= "<p>Ti consigliamo di ricopiare o stampare i dettagli di seguito riportati per futuro riferimento. Potrebbero tornarti utili come promemoria o per comunicarci gli estremi della tua iscrizione. Conservali con cura.</p>";
		
		$table = "<table style=\"border-collapse: collapse;\">";
		$i = 0;
		foreach ($data as $key => $value)
		{
			$style = "color: #7F7F7F;";
			if($i%2 == 1)
			{
				$style .= "background-color: #f7f7f7;";
			}
		
			$table .= "<tr style=\"".$style."\">";
			$table .= "<td style=\"border-top: 1px solid #ddd; border-bottom: 1px solid #ddd\">".$key."</td>";
			$table .= "<td style=\"border-top: 1px solid #ddd; border-bottom: 1px solid #ddd\">".$value."</td>";
			$table .= "</tr>";
		
			$i++;
		}
		 
		$table .= "</table>";
		
		$message .= $table;
		
		if($rights && $rights['info'] && array_key_exists('email', $userInfo))
			$this->mailer->send_mail($userInfo['email'], "Promemoria relativa alla tua pre-iscrizione ai corsi di reSeed", $message);

		$details = json_encode($cartItems) . json_encode($cartOptions);
		
		$backupMessage = "<p>L'utente <b>".$userID."</b> (nome:".$userInfo['name'].", cognome:".$userInfo['surname'].") si è appena pre-iscritto a dei corsi.</p>";
		$backupMessage .= $table;
		$backupMessage .= "<h1>Dettagli</h1>";
		$backupMessage .= $details;
		
		$this->mailer->send_mail("tiziano.flati@gmail.com", "L'utente ".$userID." (nome:".$userInfo['name'].", cognome:".$userInfo['surname'].") si è appena pre-iscritto a dei corsi.", $backupMessage);
	}
}
