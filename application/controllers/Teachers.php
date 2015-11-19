<?php
class Teachers extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper('url');
        }
        
        public function get()
        {
            $courseID = $this->input->post('courseID');
            if($courseID == false)
            {
                echo json_encode(array("error" => true, "description" => "Specificare un corso.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("courseID")));
                return;
            }

            $name = "Lorenzo";            
            $description = "Lorenzo si è laureato in informatica magistrale con specializzazione in intelligenza artificiale, interazione uomo-macchina e user interfaces.
                            Da diversi anni lavora come grafico 3D e come sviluppatore indipendente \"One-Man-Band\" di videogiochi. Curiosità: suona la chitarra in strada.";
            $avatar_URL = "imgs/team/Lorenzo.jpg";
            
            $teacher = array('name' => $name, 'description' => $description, 'avatarURL' => $avatar_URL);
            echo json_encode($teacher);
            return;
        }
}
?>