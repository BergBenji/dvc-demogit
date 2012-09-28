<?php
/**
 * Description of info
 * 
 *
 * @author BergBenji
 */
class info extends baseController {

    function __construct()
    {
	parent::__construct();
    }

    public function save()
    {
	$data = $_POST['challengeinfo'];
	$data['where'] = 'id = '.$data['id'];
	unset($data['id']);
	$this->loadModel('challenge')->updateChallenge($data);
    }
}