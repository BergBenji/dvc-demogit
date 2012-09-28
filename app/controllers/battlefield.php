<?php
/**
 * Description of battlefield
 * 
 *
 * @author BergBenji
 */
class battlefield extends baseController{

    function __construct() 
    {
	parent::__construct();
    }

    public function save() 
    {
	$data = $_POST['challengebattlefield'];
	$data['where'] = 'id = '.$data['id'];
	unset($data['id']);
	$this->loadModel('challenge')->updateChallenge($data);
    }
    
    function getChallengeBattlefieldFiles($id)
    {
	return $this->model->loadChallengeBattlefieldFiles($id);
	
    }
    
    public function fileUpload() 
    {
	$targetDir = PUBLICDIR.'challenge_files/notes/';
	$uploader = new pluploader();
	$uploader->setTargetPath($targetDir)
		 ->addSuccessCall(array('battlefield::addFile'))
		 ->startUpload();
    }
    
    public static function addFile($filename)
    {
	$challenge_id = $_POST['challenge_id'];
	$type = $_POST['area'];
	
	$c = new controller(false);
	
	$file = 'battlefield/'.$filename;
	$params = array();
	$params['challenge_id'] = $challenge_id;
	$params['filename'] = $file;
	$c->loadModel('battlefield')->addFile('sys_battlefield_files', $params);
    }
}