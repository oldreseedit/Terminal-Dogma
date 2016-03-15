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
        	$tutorialID = $this->input->post('tutorialID');
        	if($tutorialID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Specificare l'ID del tutorial.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("tutorialID")));
        		return;
        	}
        	
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
            
            $images = $this->input->post('images');
            if($images == false) $images = array();
            
            $publishing_timestamp = date("Y-m-d H:i:s");
            
            $tutorialId = $this->tutorials_model->add($tutorialID, $title, $body, $publishing_timestamp, $description, $course, $requirements, $tags, $seealso, $images);
            
            echo json_encode(array("error" => false, "description" => "Tutorial memorizzato con successo."));
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
        
        public function upload_image()
        {
        	$tutorialTitle = $this->input->post('title');
        	if($tutorialTitle == false) $tutorialTitle = "undefined";
        	
	        if ( $_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST) && empty($_FILES) && $_SERVER['CONTENT_LENGTH'] > 0 )
			{
			  echo json_encode( array( 'error' => true, 'description' => 'Uno dei file che hai caricato ('. $_SERVER['CONTENT_LENGTH']. ' byte) è troppo grande. Il massimo consentito è ' . ini_get('post_max_size')) );
			  return;
			}
		        	
        	if ( !empty( $_FILES ) )
        	{
        		$tempPath = $_FILES[ 'file' ][ 'tmp_name' ];
        		
        		$tutorial_image_dir = 'uploads' . DIRECTORY_SEPARATOR . 'tutorials';
        		
        		if(!file_exists($tutorial_image_dir)) mkdir($tutorial_image_dir);
        		
        		$uploadDir = $tutorial_image_dir . DIRECTORY_SEPARATOR . $tutorialTitle . DIRECTORY_SEPARATOR;

        		if(!file_exists($uploadDir)) mkdir($uploadDir);
        		
        		$uploadPath = $uploadDir . $_FILES[ 'file' ][ 'name' ];
        		
        		move_uploaded_file( $tempPath, $uploadPath );

        		echo json_encode( array( 'error' => false, 'description' => 'File ' . $_FILES[ 'file' ][ 'name' ] . ' caricato correttamente.', 'url' => $uploadPath) );
        	}
        	else
        	{
        		echo json_encode( array( 'error' => true, 'description' => 'Nessun file caricato...') );
        	}
        }
}
?>