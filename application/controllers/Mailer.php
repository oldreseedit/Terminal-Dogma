<?php
class Mailer extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper('url');
                $this->load->helper('email');
                $this->load->library('email');
                
                $config['protocol'] = 'sendmail';
                $config['smtp_host'] = "reseed.it";
                $config['smtp_port'] = 465;
                $config['smtp_user'] = "tflati";
                $config['smtp_password'] = "arc0bal3n0";
                $config['mailtype'] = "html";
                
                $this->email->initialize($config);
        }
        
        public function send_mail()
        {
                $from = $this->input->post('from');
                if($from == false)
                {
                        echo json_encode(array("error" => true, "description" => "L'indirizzo del mittente è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("from")));
                        return;
                }
//                 $from = "info@reseed.it";

                $name = $this->input->post('name');
                if($name == false)
                {
                        echo json_encode(array("error" => true, "description" => "Il nome è obbligatorio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("name")));
                        return;
                }
                
                if(!valid_email($from))
                {
                        echo json_encode(array("error" => true, "description" => "Fornire un indirizzo e-mail valido.", "errorCode" => "INVALID_FIELD", "parameters" => array("from")));
                        return;
                }
                $this->email->from($from, $name);
                
                // TODO: handle multiple addresses
                $this->email->to("info@reseed.it");
                
                $cc = $this->input->post('cc');
                if($cc) $this->email->cc($cc);
                
                $bcc = $this->input->post('bcc');
                if($bcc) $this->email->bcc($bcc); 
                
                $subject = $this->input->post('subject');
                if($subject == false)
                {
                        echo json_encode(array("error" => true, "description" => "Indicare un oggetto.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("subject")));
                        return;
                }
                else $this->email->subject($subject);
                
                $message = $this->input->post('message');
                if($message == false)
                {
                        echo json_encode(array("error" => true, "description" => "Indicare un messaggio.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("message")));
                        return;
                }
                else $this->email->message($message);
                
                if(!$this->email->send())
                {
                        echo json_encode(array("error" => true, "description" => "Errore durante l'invio della mail.", "errorCode" => "MAIL_ERROR"));
                        return;
                }
                else echo json_encode(array("error" => false, "description" => "La tua mail è stata inviata correttamente."));
        }
}
?>