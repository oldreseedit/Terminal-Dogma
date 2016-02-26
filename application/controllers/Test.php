<?php
class Test extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper('url');
                $this->load->helper('email');
                $this->load->library('mailer');
        }
        
        public function send_mail()
        {
        	$data = array();
        	$data['Codice transazione'] = 'WT-5H5G5WoQfrz8R8hvLu0OvHOMpbyvyIpw';
        	$data['Importo'] = '405 €';
        	$data['Modalità di pagamento'] = 'Soluzione unica';
        	$data['Pagamento da effettuarsi con'] = 'bonifico';
        	$data['IBAN'] = 'IT46H0301503200000003230046';
        	$data['Causale'] = 'reSeed - Acquisto di 1 corso e 1 simulazione';
        	$data['Intestatario'] = 'Lorenzo Bellincampi';
        	
        	$message = "<p>Grazie per aver effettuato il pagamento</p>";
        	$message = "<p>Ti consigliamo di ricopiare o stampare i dettagli di seguito riportati per futuro riferimento. Potrebbero tornarti utili come promemoria o per comunicarci gli estremi della tua iscrizione. Conservali con cura.</p>";
        	
        	$message .= "<table style=\"border-collapse: collapse;\">";
        	$i = 0;
        	foreach ($data as $key => $value)
        	{
        		$style = "color: #7F7F7F;";
        		if($i%2 == 1)
        		{
					$style .= "background-color: #f7f7f7;";
        		}
        		
        		$message .= "<tr style=\"".$style."\">";
        		$message .= "<td style=\"border-top: 1px solid #ddd; border-bottom: 1px solid #ddd\">".$key."</td>";
        		$message .= "<td style=\"border-top: 1px solid #ddd; border-bottom: 1px solid #ddd\">".$value."</td>";
        		$message .= "</tr>";
        		
        		$i++;
        	}
        	
        	$message .= "</table>";
        	$this->mailer->send_mail("tiziano.flati@gmail.com", "Test messaggio di conferma", $message);
        }
}
?>