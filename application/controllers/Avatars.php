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
            
            echo json_encode(array("error" => false, "description" => $_FILES['userfile']['tmp_name']));
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