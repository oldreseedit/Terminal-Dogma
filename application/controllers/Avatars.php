<?php

// TODO: role-based access control (offuscamento directory dei file)
// TODO: nella add: gestire corso che non esiste, ID lezione

// $this->db->error(); working?
class Avatars extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->helper('url');
                $this->load->helper('file');
        }
        
        public function load_temporary_avatar()
        {
            // No file specified
            if(count($_FILES) == 0)
            {
                echo json_encode(array("error" => true, "description" => "Errore durante il caricamento del file. Specificare un nome di file.", "errorCode" => "MISSING_FILE_ERROR", "parameters" => array("file")));
                return;
            }
            
            if ($_FILES['file']['error'] !== UPLOAD_ERR_OK)
            {
                echo json_encode(array("error" => true, "description" => "Errore durante il caricamento del file. Dettagli: " . $_FILES['file']['error'], "errorCode" => "UPLOAD_ERROR", "parameters" => array("file")));
                return;
            }
            
            // Check that the file is OK (real file type check, not based on mime)
            $is_file_okay = $this->file_OK();
            if(!$is_file_okay)
            {
            	echo json_encode(array("error" => true, "description" => "Errore durante il caricamento del file. Tipo file non permesso.", "errorCode" => "FORBIDDEN_FILE_TYPE_ERROR"));
            	return;
            }
            
            echo json_encode(array("error" => false, "description" => $_FILES['file']['tmp_name']));
        }
        
        public function load_avatar()
        {
        	$userID = $this->input->post('username');
        	if($userID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Specificare il nome utente.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
        		return;
        	}
        	
        	$tempURI = $this->input->post('avatar_temp_URI');
        	if($tempURI == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Specificare un URI temporaneo dove è stata salvata l'immagine.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("avatar_temp_URI")));
        		return;
        	}
        	
        	$fileURI = "uploads/profiles/" . $userID . "." . pathinfo($tempURI, PATHINFO_EXTENSION);
        	$uploadDir = dirname($fileURI);
        	
        	// Check if directory already exists
        	if(!file_exists($uploadDir))
        	{
        		// If it doesn't exist, create it
        		if(!mkdir($uploadDir, 0777, true))
        		{
        			return array("error" => true, "description" => "Errore durante il caricamento del file. Non è stato possibile creare la cartella dei profili.", "errorCode" => "DIRECTORY_ERROR", "parameters" => array("file"));
        		}
        	}
        	
        	// Move the avatar file
        	rename($tempURI, $fileURI);
        	
        	$this->userinfo_model->update(array('profilePicture', $fileURI));
        	
        	echo json_encode(array("error" => false, "description" => "Immagine del profilo aggiornata correttamente."));
        }
        
        public function file_OK()
        {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $_FILES['file']['tmp_name']);
            switch ($mime) {
                case 'image/jpeg':
                case 'image/jpg':                    
                case 'image/gif':
                case 'image/png':
                case 'application/pdf':
                    break;
                default:
                    return false;
            }
            
            return true;
        }
}
?>