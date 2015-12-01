<?php

// TODO: role-based access control (offuscamento directory dei file)
// TODO: nella add: gestire corso che non esiste, ID lezione

// $this->db->error(); working?
class Avatars extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('userinfo_model');
                
                $this->load->helper('url');
                $this->load->helper('file');
        }
        
        public function load_temporary_avatar()
        {
        	$userID = $this->input->post('username');
        	if($userID == false)
        	{
        		echo json_encode(array("error" => true, "description" => "Specificare il nome utente.", "errorCode" => "MANDATORY_FIELD", "parameters" => array("username")));
        		return;
        	}
        	
        	$file = count($_FILES) > 0;
        	$uri = $this->input->post('avatarUri');

        	// No file specified
        	if(!$file && !uri)
            {
                echo json_encode(array("error" => true, "description" => "Errore durante il caricamento del file. Specificare un nome di file o un URI.", "errorCode" => "MISSING_FILE_ERROR", "parameters" => array("file")));
                return;
            }
            
            $temp_file = null;
            
            if($file)
            {
	            if ($_FILES['file']['error'] !== UPLOAD_ERR_OK)
	            {
	                echo json_encode(array("error" => true, "description" => "Errore durante il caricamento del file. Dettagli: " . $_FILES['file']['error'], "errorCode" => "UPLOAD_ERROR", "parameters" => array("file")));
	                return;
	            }
	            
	            $temp_file = $_FILES['file']['tmp_name'];
            }
            else
            {
            	$temp_file = tempnam(sys_get_temp_dir(), $userID);
            	copy($uri, $temp_file);
            }
            
            // Check that the file is OK (real file type check, not based on mime)
            $is_file_okay = $this->file_OK($temp_file);
            if(!$is_file_okay)
            {
            	echo json_encode(array("error" => true, "description" => "Errore durante il caricamento del file. Tipo file non permesso.", "errorCode" => "FORBIDDEN_FILE_TYPE_ERROR"));
            	return;
            }
            
//             echo json_encode(array("error" => false, "description" => $temp_file));
            echo json_encode(array("error" => false, "description" => "http://vignette3.wikia.nocookie.net/pokemon/images/1/16/025Pikachu_OS_anime_10.png/revision/20150102074354"));
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
        	if($tempURI == false) $tempURI = $_FILES['file']['tmp_name'];
        	
        	$finfo = finfo_open(FILEINFO_MIME_TYPE);
        	$mime = finfo_file($finfo, $tempURI);
        	$extension = substr($mime, strpos($mime, "/")+1);
        	
//         	$extension = pathinfo($tempURI, PATHINFO_EXTENSION);
//         	if(empty($extension))
//         	{
//         		echo json_encode(array("error" => true, "description" => "Errore durante il caricamento del file. Non è stato possibile determinare l'estensione del file.", "errorCode" => "FORBIDDEN_FILE_TYPE_ERROR", "parameters" => array("file")));
//         		return;
//         	}

        	$fileURI = "uploads/profiles/" . $userID . (empty($extension) ? "" : "." . $extension);
        	$uploadDir = dirname($fileURI);
        	
        	// Check if directory already exists
        	if(!file_exists($uploadDir))
        	{
        		// If it doesn't exist, create it
        		if(!mkdir($uploadDir, 0777, true))
        		{
        			echo json_encode(array("error" => true, "description" => "Errore durante il caricamento del file. Non è stato possibile creare la cartella dei profili.", "errorCode" => "DIRECTORY_ERROR", "parameters" => array("file")));
        			return;
        		}
        	}
        	
        	// Move the avatar file
        	copy($tempURI, $fileURI);
        	
        	$this->userinfo_model->update($userID, array('profilePicture' => $fileURI));
        	
        	echo json_encode(array("error" => false, "description" => "Immagine del profilo aggiornata correttamente."));
        }
        
        public function file_OK($file)
        {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $file);
            switch ($mime) {
                case 'image/jpeg':
                case 'image/jpg':                    
                case 'image/gif':
                case 'image/png':
                    break;
                default:
                    return false;
            }
            
            return true;
        }
}
?>