<?php
class Tutorials extends CI_Controller {
        
        public function __construct()
        {
                parent::__construct();
                
                $this->load->model('tutorials_model');
        }
        
        public function init()
        {
        	$this->tutorials_model->init();
        }
        
        public function add()
        {
            $title = $this->input->post('title');
            if($title == false)
            {
                echo json_encode(array("error" => true, "description" => "Specificare il titolo del tutorial.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("title")));
                return;
            }
            
            $body = $this->input->post('body');
            if($body == false)
            {
            	echo json_encode(array("error" => true, "description" => "Specificare il corpo del tutorial.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("body")));
            	return;
            }
            
            $description = $this->input->post('description');
            if($description == false) $description = null;
            
            $course = $this->input->post('course');
            if($course == false) $course = null;
            
            $requirements = $this->input->post('requirements');
            if($requirements == false) $requirements = null;
            
            $tags = $this->input->post('tags');
            if($tags == false) $tags = null;
            
            $seealso = $this->input->post('seealso');
            if($seealso == false) $seealso = null;
            
            $publishing_timestamp = date("Y-m-d H:i:s");
            
            $tutorialId = $this->tutorials_model->add($title, $body, $publishing_timestamp, $description, $course, $requirements, $tags, $seealso);
            
            echo json_encode(array("error" => false, "description" => "Tutorial memorizzato con successo.", "tutorialID" => $tutorialId));
        }
        
        public function update()
        {
        	$tutorialID = $this->input->post('tutorialID');
        	if($tutorialID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Specificare l'ID del tutorial che si vuole modificare.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("tutorialID")));
        		return;
        	}
        	
        	$title = $this->input->post('title');
        	if($title == false) $title = null;
        
        	$body = $this->input->post('body');
        	if($body == false) $body = null;
        
        	$description = $this->input->post('description');
        	if($description == false) $description = null;
        
        	$course = $this->input->post('course');
        	if($course == false) $course = null;
        
        	$requirements = $this->input->post('requirements');
        	if($requirements == false) $requirements = null;
        
        	$tags = $this->input->post('tags');
        	if($tags == false) $tags = null;
        
        	$seealso = $this->input->post('seealso');
        	if($seealso == false) $seealso = null;
        
        	$publishing_timestamp = date("Y-m-d H:i:s");
        
        	$this->tutorials_model->update($tutorialID, $title, $body, $publishing_timestamp, $description, $course, $requirements, $tags, $seealso);
        
        	echo json_encode(array("error" => false, "description" => "Tutorial aggiornato con successo."));
        }
        
        public function delete()
        {
            $tutorialID = $this->input->post('tutorialID');
            if($tutorialID == false) $tutorialID = null;
            
            $this->tutorials_model->delete($tutorialID);
        }
        
        public function get()
        {
            $tutorialID = $this->input->post('tutorialID');
            if($tutorialID == false) $tutorialID = null;
            
            echo json_encode($this->tutorials_model->get($tutorialID));
        }
        
        public function get_all_tutorials()
        {
        	echo json_encode($this->tutorials_model->get_all_tutorials());
        }
}
?>