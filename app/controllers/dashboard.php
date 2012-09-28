<?php
/**
 * Description of dashboard
 * 
 * @author BergBenji
 */
class dashboard extends baseController {

    function __construct() 
    {
	parent::__construct();
	/** Checks if user is logged in **/
	if(!session::get('loggedIn')) {
	    header('location: /login');
	    exit();
	}
    }

    public function index()
    {
//	$data = $this->model->getChallenges('all');
	$data = $this->loadModel('challenge')->loadAllChallenges();
	
	
	$challenges = array();
	foreacH($data as $k => $v) {
	    $challenges[] = new helperChallenge($v);
	}
	$this->view->challenges = $challenges;
	$this->view->render('dashboard/index');
    }
    
    public function logout()
    {
	session::destroy();
	header('location: /login');
    }
    
    public function getChalanges()
    {
    }
}