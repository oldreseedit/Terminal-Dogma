<?php
class Mailer {

        public function __construct()
        {
        	$this->CI =& get_instance();
        	
			$this->CI->load->helper('url');
			
			$this->CI->load->helper('email');
			$this->CI->load->library('email');

			require_once(APPPATH . '/../../mail_credentials.php');
			
			$config['crlf'] = "\r\n";
			$config['newline'] = "\r\n";
			
			$config['mailtype'] = "html";
                
			$this->CI->email->initialize($config);
        }
        
        public function send_mail($to, $subject, $message, $from = 'info@reseed.it', $name = 'reSeed', $cc = null, $bcc = null)
        {
        	$from = 'info@reseed.it';
        	$name = 'reSeed';
        	
        	if(!valid_email($from)) return "Campo 'from' non valido";
        	if(!valid_email($to)) return "Campo 'to' non valido";
        	
        	$this->CI->email->from($from, $name);
        	$this->CI->email->to($to);
        	$this->CI->email->subject($subject);
        	$this->CI->email->message($message);
        	
        	if($cc) $this->CI->email->cc($cc);
        	if($bcc) $this->CI->email->bcc($bcc);
        	
			if($this->CI->email->send()) return "OK";
			else return $this->CI->email->print_debugger();
        }
}
?>