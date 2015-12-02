<?php

// $this->db->error(); working?
class Course_material extends CI_Controller {

        const MAX_UPLOAD_SIZE_IN_MB = 10;
        
        public function __construct()
        {
                parent::__construct();
                $this->load->model('course_material_model');
                $this->load->model('payment_model');
                $this->load->model('notifications_model');
                
                $this->load->library('permissions');
                
                $this->load->helper('url');
                $this->load->helper('file');
        }
        
        public function init()
        {
            $this->course_material_model->init();
        }
        
        public function add()
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
            
            $courseID = $this->input->post('courseID');
            if($courseID == false) $courseID = null;
            
            $lessonID = $this->input->post('lessonID');
            if($lessonID == false) $lessonID = null;
            
            $note = $this->input->post('note');
            if($note == false) $note = null;
                
            $uploadDate = date("Y-m-d H:i:s");
            $fileURI = 'uploads/' . $courseID . '/' . $_FILES['file']['name'];
            
            $result = $this->upload_file($courseID, $lessonID, $note, $uploadDate, $fileURI);
            if($result['error'])
            {
                echo json_encode($result);
                return;
            }
            
            $id = $this->course_material_model->add($lessonID, $courseID, $fileURI, $uploadDate, $note);

            // No new entry was added in the database
            if($id <= 0)
            {
                $this->removeFile($fileURI);
                
                // $this->db->error()?
                echo json_encode(array("error" => true, "description" => "Errore durante il caricamento del file.", "errorCode" => "GENERIC_ERROR"));
                return;
            }
            
            // Send out the notification
            $users = array();
            foreach($this->payment_model->get_subscribers_names($courseID) as $subscription)
            {
                array_push($users, $subscription['userID']);
            }
            $this->notifications_model->add("E' stato caricato un nuovo file", $uploadDate, $users, false, $courseID);
            
            echo json_encode($result);
            return;
        }
        
        public function modify()
        {
            $changeDB = false;

            // If there is a new file to upload
            $newFileToUpload = count($_FILES) > 0;
            if($newFileToUpload) $changeDB = true;
            if($newFileToUpload && $_FILES['file']['error'] !== UPLOAD_ERR_OK)
            {
                echo json_encode(array("error" => true, "description" => "Errore durante il caricamento del file. Dettagli: " . $_FILES['file']['error'], "errorCode" => "UPLOAD_ERROR", "parameters" => array("file")));
                return;
            }
            
            $materialID = $this->input->post('materialID');
            $previous = $this->course_material_model->get($materialID);
            if(count($previous) == 0)
            {
                echo json_encode(array("error" => true, "description" => "Specificare un materiale da rimuovere.", "errorCode" => "MANDATORY_FIELD"));
                return;
            }
            
            $courseID = $this->input->post('courseID');
            if($courseID == false) $courseID = null;
            
            $lessonID = $this->input->post('lessonID');
            if($lessonID == false) $lessonID = null;
            
            $note = $this->input->post('note');
            if($note == false) $note = null;

            // Only mv file across courses?
            if(!$newFileToUpload && $courseID == null)
            {
                rename($previousFileURI, $fileURI);
            }

            $uploadDate = null;
            $fileURI = null;
            
            if($newFileToUpload)
            {
                $uploadDate = date("Y-m-d H:i:s");
                $fileURI = 'uploads/' . ($courseID == null ? $previous['courseID'] : $courseID) . '/' . $_FILES['file']['name'];
                
                $previousFileURI = $previous['fileURI'];

                // Upload new file
                $result = $this->upload_file($courseID, $lessonID, $note, $uploadDate, $fileURI);
                if($result['error'])
                {
                    echo json_encode($result);
                    return;
                }
                
                // Remove old file
                unlink($previousFileURI);
            }
            
            // Or the course has changed
            if($courseID != null) $changeDB = true;
            
            // Or the lesson has changed
            if($lessonID != null) $changeDB = true;
            
            // Or the note has changed
            if($note != null) $changeDB = true;
            
            // Change the DB information
            if($changeDB)
                $this->course_material_model->update($materialID, $lessonID, $courseID, $fileURI, $uploadDate, $note);
            
            echo json_encode(array("error" => false, "description" => "Il materiale è stato modificato correttamente."));
            return;
        }
        
        private function upload_file($courseID, $lessonID, $note, $uploadDate, $fileURI)
        {
            if($fileURI == null)
                return array("error" => true, "description" => "Errore durante il caricamento del file. Specificare un nome di file.", "errorCode" => "MISSING_FILE_ERROR", "parameters" => array("file"));
            
            // Check that the file is OK (real file type check, not based on mime)
            $is_file_okay = $this->file_OK();
            if(!$is_file_okay)
                return array("error" => true, "description" => "Errore durante il caricamento del file. Tipo file non permesso.", "errorCode" => "FORBIDDEN_FILE_TYPE_ERROR");
            
            $uploadDir = dirname($fileURI);
            
            // Check if directory already exists
            if(!file_exists($uploadDir))
            {
                // If it doesn't exist, create it
                if(!mkdir($uploadDir, 0777, true))
                {
                    return array("error" => true, "description" => "Errore durante il caricamento del file. Non è stato possibile creare la cartella.", "errorCode" => "DIRECTORY_ERROR", "parameters" => array("file"));
                }
            }
            
            // Check that the file does not exist
            if(file_exists($fileURI))
                return array("error" => true, "description" => "Errore durante il caricamento del file. Il file già esiste.", "errorCode" => "FILE_EXISTS_ERROR", "parameters" => array("file"));
            
            $config['upload_path'] = $uploadDir;
    		$config['max_size']	= 1024 * self::MAX_UPLOAD_SIZE_IN_MB;
	        $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
            $config['remove_spaces'] = false;
            
    		$this->load->library('upload', $config);
            
    		if (!$this->upload->do_upload('file'))
    		{
    		    if(count(scandir($uploadDir)) == 2) rmdir($uploadDir);
    		    
                return array("error" => true, "description" => "Errore durante il caricamento del file. Tipo di file non permesso o dimensioni del file eccessive (massime consentite: ". self::MAX_UPLOAD_SIZE_IN_MB ." MB). Detail: " . $this->upload->display_errors('', ''), "errorCode" => "GENERIC_ERROR", "parameters" => array("file"));
    		}
    		else
    		{
    			$this->upload->data();
    			
                return array("error" => false, "description" => "Caricamento del file avvenuto con successo.");
    		}
        }
        
        public function delete()
        {
            $materialID = $this->input->post('materialID');
            if($materialID == false)
            {
                echo json_encode(array("error" => true, "description" => "Specificare un materiale da rimuovere.", "errorCode" => "MANDATORY_FIELD"));
                return;
            }
            
            $data = $this->course_material_model->get($materialID);
            if(count($data) == 0)
            {
                echo json_encode(array("error" => true, "description" => "Materiale non esistente", "errorCode" => "MISSING_FILE_ERROR"));
                return;
            }
            
            $this->course_material_model->delete($materialID);
            $this->removeFile($data['fileURI']);
            
            echo json_encode(array("error" => false, "description" => "Materiale rimosso con successo."));
            return;
        }
        
        private function removeFile($fileURI)
        {
            $basedir = dirname($fileURI);
            unlink($fileURI);
            if(count(scandir($basedir)) == 2) rmdir($basedir);
        }
        
        public function get_all()
        {
        	if(!$this->permissions->canSee())
        	{
        		echo json_encode(array());
        		return;
        	}
        	
            $courseID = $this->input->post('courseID');
            if($courseID == false) $courseID = null;
            
            $db_files = $this->course_material_model->get_course_material($courseID);
            $files = array();
            foreach($db_files as $db_file)
            {
                $file = array();
                
                $file['materialID'] = $db_file['materialID'];
                $file['lessonID'] = $db_file['lessonID'];
                $file['fileURI'] = $db_file['fileURI'];
                $file['uploadTimestamp'] = $db_file['uploadTimestamp'];
                $file['note'] = $db_file['note'] != null ? $db_file['note'] : "";
                
                array_push($files, $file);
            }
            
            echo json_encode($files);
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