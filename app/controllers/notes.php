<?php
/**
 * Description of notes
 * 
 *
 * @author BergBenji
 */
class notes extends baseController {

    function __construct() 
    {
        parent::__construct();
    }
    
    public function save()
    {
	$data = array();
	$data['where'] = 'id = '.$_POST['challengenotes']['id'];
	$data['notes'] = $_POST['challengenotes']['notes'];
	$this->loadModel('challenge')->updateChallenge($data);
    }
    
    function getChallengeNotesFiles($id)
    {
	return $this->model->loadChallengeNotesFiles($id);
    }
    
    public function fileUpload() 
    {
	$targetDir = PUBLICDIR.'challenge_files/notes/';
	$uploader = new pluploader();
	$uploader->setTargetPath($targetDir)
		 ->addSuccessCall(array('notes::addFile'))
		 ->startUpload();
    }
    
    public static function addFile($filename)
    {
	$challenge_id = $_POST['challenge_id'];
	$type = $_POST['area'];
	
	$c = new controller(false);
	
	$file = 'notes/'.$filename;
	$params = array();
	$params['challenge_id'] = $challenge_id;
	$params['filename'] = $file;
	$c->loadModel('notes')->addFile('sys_notes_files', $params);
    }   
}