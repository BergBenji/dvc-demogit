<?php


class index extends baseController {

    function __construct() {
	parent::__construct();
    }
    
    public function index($arg= false) {
	
	if(session::get('loggedIn')) {
	    header('location: /dashboard');
	    exit;
	} else {
	    header('location: /login');
	    exit;
	}
    }
    
    
}
